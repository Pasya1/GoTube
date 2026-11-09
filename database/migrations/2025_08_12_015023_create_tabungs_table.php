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
        Schema::create('tabung', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tabung')->unique();
            $table->string('nomor_seri')->unique();
            $table->string('catatan')->nullable();
            $table->enum('status', ['isi', 'kosong'])->default('isi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabung');
    }
};
