# TBN Laravel 13 — Final Setup

## Stack
- Laravel 13.25
- PHP 8.5.9
- MariaDB/MySQL XAMPP
- OTP lokal: `123456`
- AI endpoint: OpenAI-compatible `/v1/chat/completions`

## Akun demo

### Pengelola
- Email: `admin@tbn.local`
- Password: `admin123`

### Pengelola Demo
- Email: `pengelola@tbn.test`
- Password: `admin123`

### Siswa Demo
- Email: `siswa@tbn.test`
- Password: `siswa123`
- Kelas: `XII RPL 2`

Semua akun demo sudah dianggap terverifikasi pada SQL demo. Untuk akun baru, OTP lokal tetap `123456` dan tidak dikirim melalui email.

## Setelah mengganti source code

```bash
php artisan optimize:clear
php artisan migrate
php artisan storage:link
php artisan serve
```

Jika `storage:link` mengatakan link sudah ada, tidak perlu dibuat ulang.

## Database

Gunakan `database/tbn_latest.sql` untuk import database demo terbaru ke database `tbn` melalui phpMyAdmin. SQL sudah memuat:
- users + role + kelas + foto profil
- waste_categories
- waste_reports
- waste_transactions
- email verification
- sample data untuk chart/ranking/penghasilan
- normalisasi role `USER` menjadi `Siswa`

## Halaman

- `/beranda` — dashboard otomatis sesuai role
- `/ranking` — ranking siswa dan kelas + chart
- `/penghasilan` — nilai penjualan, biaya proses, net profit + chart
- `/profil` — edit data dan upload foto profil

## API JSON

Semua endpoint berikut menggunakan session login web TBN:

- `GET /api/dashboard`
- `GET /api/ranking`
- `GET /api/income`
- `GET /api/me`
- `POST /ai/chat`
- `POST /ai/identify`

Contoh:

```text
http://127.0.0.1:8000/api/dashboard
```

Endpoint API membutuhkan akun yang sudah login dan terverifikasi.

## Catatan Chart

Chart menggunakan Chart.js dari CDN. Data chart tidak hard-code; controller mengambil data dari database `waste_reports`, `waste_categories`, `waste_transactions`, dan `users`.
