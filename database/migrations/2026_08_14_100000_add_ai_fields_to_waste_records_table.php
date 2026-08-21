<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('waste_records', function (Blueprint $table) {
            $table->string('waste_name', 150)->nullable()->after('image_path');
            $table->string('condition', 80)->nullable()->after('waste_type');
            $table->decimal('ai_confidence', 5, 2)->default(0)->after('condition');
            $table->text('advice')->nullable()->after('estimated_price');
        });
    }

    public function down(): void
    {
        Schema::table('waste_records', function (Blueprint $table) {
            $table->dropColumn(['waste_name', 'condition', 'ai_confidence', 'advice']);
        });
    }
};
