<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FilmDatabaseSeeder extends Seeder
{
    /**
     * Seed data dummy untuk fitur film & kritik:
     * user, profile, genre, cast, film, peran, kritik.
     */
    public function run(): void
    {
        // 1. USER (tabel induk)
        $userIds = [];
        $users = [
            ['name' => 'Andi Saputra', 'email' => 'andi@film.test'],
            ['name' => 'Budi Santoso', 'email' => 'budi@film.test'],
            ['name' => 'Citra Lestari', 'email' => 'citra@film.test'],
        ];

        foreach ($users as $u) {
            $userIds[] = DB::table('user')->insertGetId([
                'name' => $u['name'],
                'email' => $u['email'],
                // NB: kolom password di ERD VARCHAR(45) — hash bcrypt Laravel
                // sekitar 60 karakter. Untuk seeder ini dipakai teks pendek
                // agar muat; di aplikasi nyata sebaiknya kolom ini diperbesar
                // (lihat catatan di akhir jawaban).
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. PROFILE (1-1 dengan user)
        $profiles = [
            ['umur' => 21, 'bio' => 'Mahasiswa pecinta film horor.', 'alamat' => 'Karawang, Jawa Barat'],
            ['umur' => 25, 'bio' => 'Kritikus amatir, suka drama Korea.', 'alamat' => 'Bandung, Jawa Barat'],
            ['umur' => 23, 'bio' => 'Penggemar film aksi dan superhero.', 'alamat' => 'Jakarta Selatan'],
        ];

        foreach ($profiles as $i => $p) {
            DB::table('profile')->insert([
                'umur' => $p['umur'],
                'bio' => $p['bio'],
                'alamat' => $p['alamat'],
                'user_id' => $userIds[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. GENRE
        $genreIds = [];
        foreach (['Aksi', 'Drama', 'Horor', 'Komedi'] as $nama) {
            $genreIds[$nama] = DB::table('genre')->insertGetId([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. CAST
        $castData = [
            ['nama' => 'Reza Rahadian', 'umur' => 39, 'bio' => 'Aktor senior Indonesia.'],
            ['nama' => 'Laura Basuki', 'umur' => 36, 'bio' => 'Aktris peraih banyak penghargaan.'],
            ['nama' => 'Iko Uwais', 'umur' => 41, 'bio' => 'Aktor laga, dikenal lewat film The Raid.'],
        ];
        $castIds = [];
        foreach ($castData as $c) {
            $castIds[] = DB::table('cast')->insertGetId([
                'nama' => $c['nama'],
                'umur' => $c['umur'],
                'bio' => $c['bio'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. FILM (FK ke genre)
        $filmData = [
            ['judul' => 'Malam Kelabu', 'ringkasan' => 'Kisah horor di sebuah desa terpencil.', 'tahun' => 2023, 'poster' => 'malam-kelabu.jpg', 'genre' => 'Horor'],
            ['judul' => 'Cinta di Ujung Senja', 'ringkasan' => 'Drama percintaan lintas generasi.', 'tahun' => 2022, 'poster' => 'cinta-senja.jpg', 'genre' => 'Drama'],
            ['judul' => 'Pertarungan Terakhir', 'ringkasan' => 'Aksi balas dendam seorang mantan tentara.', 'tahun' => 2024, 'poster' => 'pertarungan-terakhir.jpg', 'genre' => 'Aksi'],
        ];
        $filmIds = [];
        foreach ($filmData as $f) {
            $filmIds[] = DB::table('film')->insertGetId([
                'judul' => $f['judul'],
                'ringkasan' => $f['ringkasan'],
                'tahun' => $f['tahun'],
                'poster' => $f['poster'],
                'genre_id' => $genreIds[$f['genre']],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. PERAN (pivot film <-> cast)
        $peranData = [
            ['film' => 0, 'cast' => 0, 'nama' => 'Pak Kepala Desa'],
            ['film' => 1, 'cast' => 1, 'nama' => 'Sari'],
            ['film' => 2, 'cast' => 2, 'nama' => 'Kapten Rangga'],
            ['film' => 2, 'cast' => 0, 'nama' => 'Komandan Musuh'],
        ];
        foreach ($peranData as $p) {
            DB::table('peran')->insert([
                'film_id' => $filmIds[$p['film']],
                'cast_id' => $castIds[$p['cast']],
                'nama' => $p['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 7. KRITIK (FK ke user & film)
        $kritikData = [
            ['user' => 0, 'film' => 0, 'content' => 'Suasana mencekam sepanjang film, efek suaranya juara.', 'point' => 8],
            ['user' => 1, 'film' => 1, 'content' => 'Ceritanya menyentuh, tapi alurnya agak lambat.', 'point' => 7],
            ['user' => 2, 'film' => 2, 'content' => 'Koreografi laganya luar biasa, salah satu terbaik tahun ini.', 'point' => 9],
            ['user' => 0, 'film' => 2, 'content' => 'Seru dari awal sampai akhir, wajib nonton di bioskop.', 'point' => 9],
        ];
        foreach ($kritikData as $k) {
            DB::table('kritik')->insert([
                'user_id' => $userIds[$k['user']],
                'film_id' => $filmIds[$k['film']],
                'content' => $k['content'],
                'point' => $k['point'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
