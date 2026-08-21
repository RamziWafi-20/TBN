<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(30) NOT NULL DEFAULT 'Siswa'");
        }

        DB::table('users')->where('role', 'admin')->update(['role' => 'Pengelola']);
        DB::table('users')->where('role', 'siswa')->update(['role' => 'Siswa']);
        DB::table('users')->where('role', 'USER')->update(['role' => 'Siswa']);
    }

    public function down(): void
    {
        // Intentionally left compatible with existing user data.
    }
};
