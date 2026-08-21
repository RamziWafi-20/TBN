# TBN Laravel 13 — Setup

Project ini menggunakan Laravel 13 dan mempertahankan tampilan Blade yang sudah ada. Fitur yang diperbaiki:
- Registrasi memakai kode OTP 6 digit melalui email.
- Akun tidak otomatis login sebelum email diverifikasi.
- Kode berlaku 10 menit, maksimal 5 percobaan, resend dibatasi.
- Login menolak akun yang belum terverifikasi.
- Eco AI chat memakai endpoint OpenAI-compatible.
- AI Scanner mengirim foto dan menampilkan nama serta jenis sampah hasil AI.
- Animasi ditambahkan sebagai motion layer tanpa mengubah struktur layout utama.

## 1. Database

Buat database MySQL bernama `tbn`, lalu cek `.env`:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tbn
DB_USERNAME=root
DB_PASSWORD=

Jalankan dari folder project:

```bat
cd D:\xampp-portable-windows-x64-8.2.12-0-VS16\xampp\htdocs\tbn-laravel-project
composer install
php artisan optimize:clear
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Jika database ini sudah pernah dipakai versi sebelumnya dan migration status sudah tidak sinkron, backup database dahulu. Untuk instalasi baru paling aman gunakan database `tbn` kosong.

## 2. Email OTP

Untuk Gmail, gunakan App Password, bukan password Gmail biasa. Isi:

MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=alamatgmailanda@gmail.com
MAIL_PASSWORD=APP_PASSWORD_GMAIL
MAIL_FROM_ADDRESS=alamatgmailanda@gmail.com
MAIL_FROM_NAME="TBN"

Setelah mengubah `.env`:

```bat
php artisan optimize:clear
```

Tanpa kredensial SMTP, kode tidak dapat dikirim ke inbox sungguhan.

## 3. AI Chat dan AI Scanner

Isi:

AI_API_URL=https://api.openai.com/v1/chat/completions
AI_API_KEY=sk-xxxxxxxx
AI_MODEL=gpt-4o-mini
AI_VISION_MODEL=gpt-4o-mini

Pastikan API key memiliki akses ke model yang dipilih. Setelah mengubah `.env`:

```bat
php artisan optimize:clear
```

AI Scanner menerima JPG/JPEG/PNG/WEBP maksimal 10 MB.

## 4. Jalankan

```bat
php artisan serve
```

Buka:
http://127.0.0.1:8000

## 5. Akun demo

Siswa:
- Email: siswa@neskar.sch.id
- Password: password123

Pengelola:
- Email: admin@neskar.sch.id
- Password: password123

Akun demo sudah ditandai terverifikasi oleh seeder sehingga bisa langsung dipakai untuk menguji dashboard.

## Catatan

Tidak ada API key email atau AI yang disertakan dalam project. Credential harus diisi oleh pemilik aplikasi agar tidak bocor.
