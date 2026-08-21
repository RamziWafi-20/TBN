# TBN — Trash Bank Neskar (Laravel 13)

Project ini mempertahankan tampilan TBN yang sudah ada, sementara fitur backend yang sebelumnya simulasi sudah dibuat fungsional:

- Register memakai database Laravel.
- Password di-hash.
- Login memakai session/auth Laravel.
- Akun baru WAJIB verifikasi email sebelum bisa login.
- Tautan verifikasi memakai signed temporary URL Laravel dan dapat diklik dari email.
- Resend verification tersedia.
- Eco AI Chat terhubung ke endpoint AI yang kompatibel dengan OpenAI Chat Completions.
- AI Waste Scanner menerima JPG/JPEG/PNG/WEBP dan mengirim foto ke model vision.
- Hasil scanner menampilkan nama sampah, jenis/material, confidence, kondisi, estimasi berat/nilai, dan saran.
- Hasil scan disimpan ke database dan muncul pada Riwayat Setoran.
- CSRF, authentication, email verification, validation, upload validation, dan throttling sudah dipasang.

## 1. Persiapan

Gunakan PHP 8.3+ dan Laravel 13.

```bash
composer install
npm install
php artisan key:generate
php artisan migrate
php artisan storage:link
```

Jika database lama sudah pernah dipakai, jalankan:

```bash
php artisan migrate
```

Untuk data demo:

```bash
php artisan db:seed
```

Demo:
- siswa@neskar.sch.id / password123
- admin@neskar.sch.id / password123

Akun demo sudah ditandai terverifikasi sehingga bisa langsung login.

## 2. Email Verification

Email asli harus dikonfigurasi di `.env`.

Contoh Gmail SMTP:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=EMAIL_GMAIL_ANDA
MAIL_PASSWORD=APP_PASSWORD_GMAIL
MAIL_FROM_ADDRESS=EMAIL_GMAIL_ANDA
MAIL_FROM_NAME="${APP_NAME}"
```

`MAIL_PASSWORD` untuk Gmail sebaiknya menggunakan App Password, bukan password utama akun Gmail.

Setelah mengubah `.env`:

```bash
php artisan optimize:clear
```

## 3. Eco AI + AI Image Scanner

Isi kredensial provider AI yang Anda gunakan:

```env
AI_API_URL=https://api.openai.com/v1/chat/completions
AI_API_KEY=ISI_API_KEY_ANDA
AI_MODEL=gpt-4o-mini
AI_VISION_MODEL=gpt-4o-mini
```

Jangan memasukkan API key ke JavaScript/browser. Key hanya dibaca server melalui `.env`.

Scanner mengharapkan model vision yang mendukung image input. Jika provider memakai endpoint/model berbeda, sesuaikan tiga nilai `AI_*` di `.env`.

Setelah perubahan:

```bash
php artisan optimize:clear
```

## 4. Jalankan

```bash
php artisan serve
```

Buka:

`http://localhost:8000`

## 5. Alur Register

1. Pengguna memilih Daftar Akun.
2. Mengisi nama, email, NIS, role, dan password.
3. Data user disimpan.
4. Sistem otomatis mengirim email verifikasi.
5. User membuka email dan klik tombol verifikasi.
6. Email ditandai verified.
7. User kembali ke halaman login dan dapat masuk.
8. User yang belum verified akan ditolak saat login.

## 6. Catatan penting

AI dan email membutuhkan kredensial layanan eksternal. Project tidak menyertakan API key atau password SMTP agar kredensial pribadi tidak bocor.

Tampilan UI tidak didesain ulang; perubahan difokuskan pada koneksi database, authentication, email verification, AI API, upload gambar, penyimpanan hasil, dan JavaScript agar fitur yang sebelumnya hanya simulasi menjadi nyata.
