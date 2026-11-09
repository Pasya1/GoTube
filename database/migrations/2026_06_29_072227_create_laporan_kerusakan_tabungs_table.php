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
        Schema::create('laporan_kerusakan_tabungs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengiriman_id')->constrained()->cascadeOnDelete();

            $table->foreignId('tabung_id')->constrained('tabung')->cascadeOnDelete();

            $table->text('catatan');

            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai'
            ])->default('menunggu');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan_tabungs');
    }
};
