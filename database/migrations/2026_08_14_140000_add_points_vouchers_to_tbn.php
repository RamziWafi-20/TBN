<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'points')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedInteger('points')->default(0)->after('profile_photo');
            });
        }

        if (!Schema::hasTable('point_transactions')) {
            Schema::create('point_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->integer('points');
                $table->string('type', 40);
                $table->string('reference_type', 100)->nullable();
                $table->unsignedBigInteger('reference_id')->nullable();
                $table->string('description', 255)->nullable();
                $table->unsignedInteger('balance_after')->default(0);
                $table->timestamps();
                $table->index(['user_id', 'created_at']);
            });
        }

        if (!Schema::hasTable('vouchers')) {
            Schema::create('vouchers', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->enum('type', ['wifi', 'koperasi']);
                $table->string('code', 100)->unique();
                $table->unsignedInteger('points_cost');
                $table->unsignedInteger('stock')->default(1);
                $table->boolean('is_active')->default(true);
                $table->timestamp('expires_at')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
                $table->index(['type', 'is_active']);
            });
        }

        if (!Schema::hasTable('voucher_redemptions')) {
            Schema::create('voucher_redemptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('voucher_id')->constrained('vouchers')->restrictOnDelete();
                $table->string('voucher_code', 100);
                $table->unsignedInteger('points_spent');
                $table->enum('status', ['Berhasil', 'Dibatalkan'])->default('Berhasil');
                $table->timestamp('redeemed_at')->useCurrent();
                $table->timestamps();
                $table->index(['user_id', 'created_at']);
            });
        }

        if (DB::getDriverName() === 'mysql') {
            DB::table('vouchers')->insertOrIgnore([
                [
                    'name' => 'Voucher WiFi 1 Jam', 'type' => 'wifi', 'code' => 'WIFI-TBN-1JAM',
                    'points_cost' => 50, 'stock' => 10, 'is_active' => 1,
                    'description' => 'Voucher akses WiFi sekolah selama 1 jam.',
                    'created_at' => now(), 'updated_at' => now(),
                ],
                [
                    'name' => 'Voucher Koperasi Rp10.000', 'type' => 'koperasi', 'code' => 'KOP-TBN-10K',
                    'points_cost' => 100, 'stock' => 10, 'is_active' => 1,
                    'description' => 'Voucher belanja koperasi sekolah senilai Rp10.000.',
                    'created_at' => now(), 'updated_at' => now(),
                ],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('voucher_redemptions');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('point_transactions');
        if (Schema::hasColumn('users', 'points')) {
            Schema::table('users', fn (Blueprint $table) => $table->dropColumn('points'));
        }
    }
};
