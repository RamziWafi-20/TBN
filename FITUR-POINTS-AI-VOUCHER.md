# TBN — AI, Foto Sampah, Points & Voucher

## Fitur yang ditambahkan
- Scanner foto sampah siswa melalui `/ai/identify`.
- Foto disimpan di `storage/app/public/waste-scans`.
- Setiap foto yang berhasil diterima memberikan **10 poin**.
- Foto otomatis dibuat menjadi data `waste_records` dan `waste_reports` dengan status `Menunggu` agar dapat dipantau pengelola.
- Eco AI chat melalui `/ai/chat`.
- Jika `AI_API_KEY` kosong, scanner foto tetap menerima dan menyimpan foto serta chat menggunakan fallback Eco AI lokal sederhana.
- Jika `AI_API_KEY` diisi, scanner memakai analisis vision dan chat memakai model AI sesuai `.env`.
- Halaman Poin & Voucher: `/poin`.
- Pengelola dapat mengelola voucher WiFi/koperasi: `/voucher`.
- Penukaran voucher memakai transaksi database + row lock agar poin/stok tidak mudah double-spend ketika ada request bersamaan.
- API points, voucher, redeem, chat, dan image identify tersedia di `/api/...`.
- Mode gelap dengan gradient hijau gelap dan disimpan di browser melalui localStorage.

## Database
Jalankan salah satu:

### Laravel migration
```bash
php artisan migrate
```

### phpMyAdmin
Buka `database/tbn_points_vouchers_patch.sql`, pastikan database `tbn` dipilih, lalu jalankan seluruh script.

## Storage
Jika `public/storage` belum ada:
```bash
php artisan storage:link
```
Jika muncul `link already exists`, tidak perlu dibuat ulang.

## AI
Isi di `.env`:
```env
AI_API_URL=https://api.openai.com/v1/chat/completions
AI_API_KEY=ISI_API_KEY_ANDA
AI_MODEL=gpt-4o-mini
AI_VISION_MODEL=gpt-4o-mini
```
Lalu:
```bash
php artisan optimize:clear
php artisan serve
```

Tanpa `AI_API_KEY`, fitur foto dan chat tetap memiliki fallback lokal sehingga halaman tidak mati hanya karena API AI belum dikonfigurasi.
