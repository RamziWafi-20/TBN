<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'nis')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nis', 30)->nullable()->after('email');
            });
        }

        if (!Schema::hasColumn('users', 'class_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('class_name', 50)->nullable()->after('nis');
            });
        }

        if (!Schema::hasColumn('users', 'profile_photo')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_photo')->nullable()->after('class_name');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['class_name', 'profile_photo']);
        });
    }
};
