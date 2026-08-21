<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')
                ->constrained('film')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('cast_id')
                ->constrained('cast')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nama', 45); // nama karakter yang diperankan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peran');
    }
};
