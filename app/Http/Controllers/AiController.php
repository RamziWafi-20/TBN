<?php

namespace App\Http\Controllers;

use App\Models\WasteRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\PointTransaction;
use App\Models\WasteReport;
use Illuminate\Support\Str;
use Throwable;

class AiController extends Controller
{
    private function endpoint(): string
    {
        return rtrim((string) config('services.ai.url'), '/');
    }

    private function key(): ?string
    {
        return config('services.ai.key') ?: null;
    }

    private function call(array $payload, int $timeout = 90)
    {
        if (!$this->key()) {
            return null;
        }

        return Http::timeout($timeout)
            ->connectTimeout(20)
            ->retry(2, 700)
            ->withToken($this->key())
            ->acceptJson()
            ->post($this->endpoint(), $payload);
    }

    public function chat(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ]);

        if (!$this->key()) {
            return response()->json(['message' => $this->localChat($data['message'])]);
        }

        try {
            $response = $this->call([
                'model' => config('services.ai.model', 'gpt-4o-mini'),
                'temperature' => 0.4,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah Eco AI untuk TBN (Trash Bank Neskar) di SMKN 1 Karawang. Jawab dalam bahasa Indonesia dengan ramah, jelas, ringkas, akurat, dan praktis. Fokus pada pemilahan sampah, daur ulang, bank sampah, upcycling, dan ekonomi sirkular. Jangan mengarang harga resmi TBN.',
                    ],
                    ['role' => 'user', 'content' => $data['message']],
                ],
            ], 60);

            if (!$response || $response->failed()) {
                $detail = $response ? data_get($response->json(), 'error.message') : null;
                return response()->json([
                    'message' => $detail
                        ? 'Eco AI gagal merespons: ' . Str::limit($detail, 250)
                        : 'Eco AI gagal terhubung. Periksa AI_API_URL, AI_API_KEY, koneksi internet, dan AI_MODEL pada .env.',
                ], 502);
            }

            $content = data_get($response->json(), 'choices.0.message.content');

            if (is_array($content)) {
                $content = collect($content)->map(fn ($item) => $item['text'] ?? '')->filter()->implode("\n");
            }

            if (!$content) {
                return response()->json(['message' => 'Respons AI kosong. Silakan coba lagi.'], 502);
            }

            return response()->json(['message' => trim((string) $content)]);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Terjadi kesalahan saat menghubungi Eco AI. Periksa koneksi internet dan konfigurasi AI.'], 500);
        }
    }

    private function localChat(string $message): string
    {
        $q = Str::lower($message);
        if (Str::contains($q, ['poin', 'point'])) return 'Setiap foto sampah yang berhasil dikirim melalui Scanner TBN memberikan 10 poin. Poin dapat ditukar dengan voucher WiFi atau voucher koperasi jika stok tersedia.';
        if (Str::contains($q, ['plastik', 'botol'])) return 'Botol plastik sebaiknya dikosongkan, dibilas jika memungkinkan, dikeringkan, lalu dipisahkan dari sampah lain agar mudah didaur ulang.';
        if (Str::contains($q, ['organik', 'sisa makanan'])) return 'Sampah organik seperti sisa makanan dapat dipisahkan untuk kompos. Hindari mencampurnya dengan plastik dan logam.';
        if (Str::contains($q, ['kertas', 'kardus'])) return 'Kertas dan kardus sebaiknya tetap kering dan bersih. Lipat agar hemat tempat sebelum dikumpulkan ke bank sampah.';
        return 'Saya Eco AI TBN. Saya bisa membantu tentang pemilahan sampah, bank sampah, daur ulang, poin, dan voucher. Untuk analisis AI yang lebih lengkap, isi AI_API_KEY di .env.';
    }

    public function identify(Request $request)
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ], [
            'image.required' => 'Pilih foto sampah terlebih dahulu.',
            'image.image' => 'File yang dipilih harus berupa gambar.',
            'image.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 10 MB.',
        ]);

        if (!$this->key()) {
            try {
                $file = $data['image'];
                $imagePath = $file->store('waste-scans', 'public');
                $record = DB::transaction(function () use ($request, $imagePath) {
                    $record = WasteRecord::create([
                        'user_id' => $request->user()->id,
                        'image_path' => $imagePath,
                        'waste_name' => 'Setoran foto — menunggu verifikasi',
                        'waste_type' => 'Belum diklasifikasikan',
                        'condition' => 'Menunggu verifikasi',
                        'ai_confidence' => 0,
                        'estimated_weight' => 0,
                        'estimated_price' => 0,
                        'advice' => 'Foto sudah diterima. Pengelola dapat memverifikasi data setoran ini.',
                    ]);
                    WasteReport::create([
                        'code' => 'TBN-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5)),
                        'user_id' => $request->user()->id,
                        'image_path' => $imagePath,
                        'ai_confidence' => 0,
                        'ai_estimated_weight' => 0,
                        'estimated_value' => 0,
                        'status' => 'Menunggu',
                        'notes' => 'Foto setoran diterima melalui Scanner TBN; menunggu verifikasi pengelola.',
                    ]);
                    $user = $request->user()->fresh();
                    $user->increment('points', 10);
                    $user->refresh();
                    PointTransaction::create([
                        'user_id' => $user->id, 'points' => 10, 'type' => 'waste_photo',
                        'reference_type' => WasteRecord::class, 'reference_id' => $record->id,
                        'description' => 'Bonus 10 poin dari upload foto sampah', 'balance_after' => $user->points,
                    ]);
                    return $record;
                });
                return response()->json([
                    'message' => 'Foto berhasil dikirim sebagai data pengumpulan sampah. Kamu mendapatkan 10 poin.',
                    'result' => [
                        'id' => $record->id, 'name' => $record->waste_name, 'type' => $record->waste_type,
                        'condition' => $record->condition, 'confidence' => 0, 'weight' => 0, 'price' => 0,
                        'advice' => $record->advice, 'points_earned' => 10,
                        'points_balance' => (int) $request->user()->fresh()->points,
                        'image_url' => Storage::disk('public')->url($record->image_path),
                    ],
                ]);
            } catch (Throwable $e) {
                report($e);
                return response()->json(['message' => 'Foto gagal disimpan. Periksa folder storage dan permission aplikasi.'], 500);
            }
        }

        try {
            $file = $data['image'];
            $mime = $file->getMimeType() ?: 'image/jpeg';
            $base64 = base64_encode(file_get_contents($file->getRealPath()));

            $prompt = <<<PROMPT
Identifikasi benda/sampah pada gambar untuk sistem bank sampah sekolah.
Kembalikan HANYA JSON valid, tanpa markdown, dengan struktur:
{
  "name": "nama benda/sampah yang spesifik",
  "type": "jenis material/kategori sampah",
  "confidence": 0,
  "condition": "bersih/kotor/tidak dapat ditentukan",
  "estimated_weight_kg": 0,
  "estimated_price_idr": 0,
  "advice": "saran pemilahan singkat"
}
confidence adalah angka 0-100. Jangan mengarang harga resmi TBN. Jika berat atau harga tidak dapat ditentukan dari foto, isi 0. Jika objek tidak jelas, gunakan nama "Tidak teridentifikasi dengan pasti" dan jelaskan alasannya di advice.
PROMPT;

            $response = $this->call([
                'model' => config('services.ai.vision_model', config('services.ai.model', 'gpt-4o-mini')),
                'temperature' => 0.1,
                'messages' => [[
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $prompt],
                        ['type' => 'image_url', 'image_url' => [
                            'url' => "data:{$mime};base64,{$base64}",
                            'detail' => 'high',
                        ]],
                    ],
                ]],
            ], 120);

            if (!$response || $response->failed()) {
                $detail = $response ? data_get($response->json(), 'error.message') : null;
                return response()->json([
                    'message' => $detail
                        ? 'AI gagal menganalisis foto: ' . Str::limit($detail, 250)
                        : 'AI gagal menganalisis foto. Pastikan model vision mendukung gambar dan AI_API_KEY benar.',
                ], 502);
            }

            $raw = trim((string) data_get($response->json(), 'choices.0.message.content', ''));
            $raw = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', $raw);
            $result = json_decode($raw, true);

            if (!is_array($result) || empty($result['name']) || empty($result['type'])) {
                return response()->json(['message' => 'AI mengembalikan hasil yang tidak valid. Silakan gunakan foto yang lebih jelas dan coba lagi.'], 502);
            }

            $imagePath = $file->store('waste-scans', 'public');

            $record = DB::transaction(function () use ($request, $imagePath, $result) {
                $record = WasteRecord::create([
                'user_id' => $request->user()->id,
                'image_path' => $imagePath,
                'waste_name' => Str::limit((string) $result['name'], 150, ''),
                'waste_type' => Str::limit((string) $result['type'], 100, ''),
                'condition' => Str::limit((string) ($result['condition'] ?? 'Tidak diketahui'), 80, ''),
                'ai_confidence' => min(100, max(0, (float) ($result['confidence'] ?? 0))),
                'estimated_weight' => max(0, (float) ($result['estimated_weight_kg'] ?? 0)),
                'estimated_price' => max(0, (float) ($result['estimated_price_idr'] ?? 0)),
                'advice' => Str::limit((string) ($result['advice'] ?? ''), 500, ''),
                ]);

                WasteReport::create([
                    'code' => 'TBN-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5)),
                    'user_id' => $request->user()->id,
                    'image_path' => $imagePath,
                    'ai_confidence' => $record->ai_confidence,
                    'ai_estimated_weight' => $record->estimated_weight,
                    'estimated_value' => $record->estimated_price,
                    'status' => 'Menunggu',
                    'notes' => $record->advice,
                ]);

                $user = $request->user()->fresh();
                $user->increment('points', 10);
                $user->refresh();
                PointTransaction::create([
                    'user_id' => $user->id,
                    'points' => 10,
                    'type' => 'waste_photo',
                    'reference_type' => WasteRecord::class,
                    'reference_id' => $record->id,
                    'description' => 'Bonus 10 poin dari upload foto sampah',
                    'balance_after' => $user->points,
                ]);
                return $record;
            });

            return response()->json([
                'message' => 'Sampah berhasil diidentifikasi.',
                'result' => [
                    'id' => $record->id,
                    'name' => $record->waste_name,
                    'type' => $record->waste_type,
                    'condition' => $record->condition,
                    'confidence' => (float) $record->ai_confidence,
                    'weight' => (float) $record->estimated_weight,
                    'price' => (float) $record->estimated_price,
                    'advice' => $record->advice,
                    'points_earned' => 10,
                    'points_balance' => (int) $request->user()->fresh()->points,
                    'image_url' => Storage::disk('public')->url($record->image_path),
                ],
            ]);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Terjadi kesalahan saat memproses gambar. Coba foto lain dengan pencahayaan yang lebih baik.'], 500);
        }
    }
}
