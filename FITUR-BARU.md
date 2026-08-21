# TBN — Fitur Dashboard Baru

Versi ini mempertahankan sistem login + OTP dummy `123456` yang sudah berhasil, lalu menambahkan 4 halaman utama baru:

1. **Ranking / Peringkat** — ranking kontributor berdasarkan total berat sampah + diagram kontribusi per kelas.
2. **Penghasilan** — total penghasilan, berat, transaksi, rata-rata nilai, diagram nilai per bulan, dan transaksi terbaru.
3. **Profil** — profil siswa/pengelola, edit nama/NIS/kelas, dan upload foto profil.
4. **Dashboard Pengelola** — dashboard khusus Pengelola/Guru dengan total sampah, nilai ekonomi, transaksi, pengguna, dan transaksi terbaru.

Dashboard Siswa juga dibuat berbeda dari dashboard Pengelola.

## Setelah extract

```bash
composer install
npm install
php artisan migrate
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

Gunakan MySQL database `tbn` seperti konfigurasi `.env`.

### OTP lokal

```text
OTP = 123456
```

Tidak membutuhkan SMTP/email untuk verifikasi akun.

### Kelas

Saat registrasi, kolom **Kelas** sekarang tersedia. Kelas juga bisa diubah melalui halaman Profil. Data kelas digunakan pada ranking/diagram per kelas.
