<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('waste_categories')) {
            Schema::create('waste_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('material');
                $table->decimal('default_price_per_kg', 12, 2);
                $table->string('color')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('waste_reports')) {
            Schema::create('waste_reports', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('waste_category_id')->nullable()->constrained('waste_categories')->nullOnDelete();
                $table->string('image_path')->nullable();
                $table->decimal('ai_confidence', 5, 2)->nullable();
                $table->decimal('ai_estimated_weight', 10, 2)->nullable();
                $table->decimal('actual_weight', 10, 2)->nullable();
                $table->decimal('estimated_value', 12, 2)->nullable();
                $table->decimal('actual_value', 12, 2)->nullable();
                $table->enum('status', ['Menunggu', 'Diverifikasi', 'Dikumpulkan', 'Ditimbang', 'Diproses', 'Selesai'])->default('Menunggu');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('waste_transactions')) {
            Schema::create('waste_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('waste_report_id')->constrained('waste_reports')->cascadeOnDelete();
                $table->string('type');
                $table->decimal('gross_value', 12, 2);
                $table->decimal('processing_cost', 12, 2);
                $table->decimal('selling_value', 12, 2);
                $table->decimal('net_profit', 12, 2);
                $table->date('transaction_date');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_transactions');
        Schema::dropIfExists('waste_reports');
        Schema::dropIfExists('waste_categories');
    }
};
