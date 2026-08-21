<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tbn.local'],
            [
                'username' => 'TBNADMIN',
                'name' => 'TBN Administrator',
                'nis' => null,
                'class_name' => null,
                'role' => 'Pengelola',
                'password' => 'admin123',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@tbn.test'],
            [
                'username' => 'SISWADUMMY',
                'name' => 'Siswa Demo TBN',
                'nis' => '0098765432',
                'class_name' => 'XII RPL 2',
                'role' => 'Siswa',
                'password' => 'siswa123',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'pengelola@tbn.test'],
            [
                'username' => 'PENGELOLADUMMY',
                'name' => 'Pengelola Demo TBN',
                'nis' => null,
                'class_name' => null,
                'role' => 'Pengelola',
                'password' => 'admin123',
                'email_verified_at' => now(),
            ]
        );
    }
}
