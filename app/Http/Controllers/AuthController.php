<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function show(Request $request)
    {
        return view('auth.login', ['tab' => $request->query('tab', 'login')]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])
                ->withInput($request->only('email'));
        }

        if (!$user->hasVerifiedEmail()) {
            $request->session()->put('verification_email', $user->email);
            return redirect()->route('verification.code')
                ->with('info', 'Akun belum terverifikasi. Masukkan kode OTP dummy yang ditampilkan di halaman verifikasi.');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('beranda'))->with('success', 'Selamat datang kembali di TBN!');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'nis' => ['nullable', 'string', 'max:30'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'role' => ['required', Rule::in(['Siswa', 'Guru', 'Pengelola'])],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'role.required' => 'Pilih peran Anda.',
            'role.in' => 'Peran yang dipilih tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $usernameBase = Str::upper(Str::substr(Str::before($data['email'], '@'), 0, 50));
        $username = $usernameBase;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = Str::substr($usernameBase, 0, 55) . $counter++;
        }

        $user = User::create([
            'username' => $username,
            'name' => $data['name'],
            'email' => $data['email'],
            'nis' => $data['nis'] ?? null,
            'class_name' => $data['class_name'] ?? null,
            'role' => $data['role'],
            'password' => $data['password'],
        ]);

        $this->sendVerificationCode($user);

        $request->session()->put('verification_email', $user->email);

        return redirect()->route('verification.code')
            ->with('success', 'Akun berhasil dibuat. Gunakan OTP dummy yang ditampilkan di halaman verifikasi.');
    }

    public function showVerificationCode(Request $request)
    {
        $email = $request->session()->get('verification_email');

        if (!$email) {
            return redirect()->route('auth.show')->with('info', 'Silakan daftar atau masuk terlebih dahulu.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $request->session()->forget('verification_email');
            return redirect()->route('auth.show')->withErrors(['email' => 'Akun tidak ditemukan.']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('auth.show')->with('success', 'Email sudah terverifikasi. Silakan masuk.');
        }

        return view('auth.verify-code', compact('user'));
    }

    public function verifyCode(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'digits:6'],
        ], [
            'code.required' => 'Kode verifikasi wajib diisi.',
            'code.digits' => 'Kode verifikasi harus terdiri dari 6 angka.',
        ]);

        $email = $request->session()->get('verification_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (!$user) {
            return redirect()->route('auth.show')->withErrors([
                'email' => 'Sesi verifikasi tidak ditemukan. Silakan daftar atau masuk kembali.'
            ]);
        }

        // MODE DUMMY/LOCAL:
        // Semua akun menggunakan satu OTP tetap. Tidak bergantung pada
        // email, SMTP, Mailpit, atau record OTP yang tersimpan di database.
        if (env('OTP_MODE', 'dummy') === 'dummy') {
            $dummyCode = '123456';

            if ($data['code'] !== $dummyCode) {
                return back()->withErrors([
                    'code' => 'Kode OTP dummy salah. Gunakan OTP: ' . $dummyCode
                ])->withInput();
            }

            $user->markEmailAsVerified();
            DB::table('email_verification_codes')->where('user_id', $user->id)->delete();
            $request->session()->forget(['verification_email', 'verification_otp']);

            return redirect()->route('auth.show')->with(
                'success',
                'Akun berhasil diverifikasi. Sekarang Anda dapat masuk ke akun TBN.'
            );
        }

        // MODE EMAIL/PRODUCTION (tetap tersedia jika nanti ingin diaktifkan).
        $record = DB::table('email_verification_codes')
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        if (!$record || now()->greaterThan($record->expires_at)) {
            return back()->withErrors(['code' => 'Kode sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        if ($record->attempts >= 5) {
            return back()->withErrors(['code' => 'Terlalu banyak percobaan. Silakan minta kode baru.']);
        }

        if (!Hash::check($data['code'], $record->code_hash)) {
            DB::table('email_verification_codes')->where('id', $record->id)->increment('attempts');
            return back()->withErrors(['code' => 'Kode verifikasi salah. Silakan periksa email Anda.']);
        }

        $user->markEmailAsVerified();
        DB::table('email_verification_codes')->where('user_id', $user->id)->delete();
        $request->session()->forget(['verification_email', 'verification_otp']);

        return redirect()->route('auth.show')->with(
            'success',
            'Akun berhasil diverifikasi. Sekarang Anda dapat masuk ke akun TBN.'
        );
    }

    public function resendCode(Request $request)
    {
        $email = $request->session()->get('verification_email');
        $user = $email ? User::where('email', $email)->first() : null;

        if (!$user) {
            return redirect()->route('auth.show')->withErrors(['email' => 'Sesi verifikasi tidak ditemukan.']);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('auth.show')->with('info', 'Email sudah terverifikasi.');
        }

        $key = 'verification-resend:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors(['code' => 'Terlalu banyak permintaan. Coba lagi dalam beberapa menit.']);
        }

        RateLimiter::hit($key, 60);
        $this->sendVerificationCode($user);

        return back()->with('success', 'OTP dummy baru telah dibuat. Gunakan kode yang ditampilkan di halaman ini.');
    }

    private function sendVerificationCode(User $user): void
    {
        // Mode OTP dummy untuk development/local. Tidak mengirim email.
        // Atur OTP_MODE=dummy pada .env. Kode default: 123456.
        $code = env('OTP_MODE', 'dummy') === 'dummy'
            ? (string) env('OTP_DUMMY_CODE', '123456')
            : (string) random_int(100000, 999999);

        DB::table('email_verification_codes')->where('user_id', $user->id)->delete();

        DB::table('email_verification_codes')->insert([
            'user_id' => $user->id,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
            'attempts' => 0,
            'last_sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan OTP di session agar bisa ditampilkan pada halaman verifikasi.
        // Ini hanya untuk mode dummy/local. Jangan gunakan pada production.
        if (env('OTP_MODE', 'dummy') === 'dummy') {
            session()->put('verification_otp', $code);
        }
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (in_array($user->role, ['Pengelola', 'Guru'], true)) {
            $reports = \App\Models\WasteReport::with(['user', 'category', 'transaction'])->latest()->get();
            $transactions = $reports->pluck('transaction')->filter();

            return view('app.manager-dashboard', [
                'user' => $user,
                'wasteRecords' => $reports->take(10),
                'totalWeight' => (float) $reports->sum(fn ($r) => $r->effective_weight),
                'totalIncome' => (float) $reports->sum(fn ($r) => $r->effective_value),
                'totalTransactions' => $transactions->count(),
                'totalUsers' => User::count(),
                'totalStudents' => User::where('role', 'Siswa')->count(),
                'totalProfit' => (float) $transactions->sum('net_profit'),
                'chartData' => app(\App\Http\Controllers\AnalyticsController::class)->dashboardData($user),
                'latestScans' => \App\Models\WasteRecord::with('user')->latest()->limit(8)->get(),
            ]);
        }

        $reports = $user->wasteReports()->with(['category', 'transaction'])->latest()->get();
        $transactions = $reports->pluck('transaction')->filter();

        return view('app.student-dashboard', [
            'user' => $user,
            'wasteRecords' => $reports->take(10),
            'totalWeight' => (float) $reports->sum(fn ($r) => $r->effective_weight),
            'totalIncome' => (float) $reports->sum(fn ($r) => $r->effective_value),
            'totalTransactions' => $transactions->count(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'Anda telah berhasil keluar.');
    }
}
