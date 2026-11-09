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
        Schema::create('outlet', function (Blueprint $table) {
            $table->id();
            $table->string('nama_outlet');
            $table->string('nama_spv')->nullable();
            $table->string('nama_area')->nullable();
            $table->string('merk_inflator')->nullable();
            $table->string('merk_regulator')->nullable();
            $table->string('distribusi_by')->nullable();
            $table->string('nama_vendor')->nullable();
            $table->decimal('harga_isi_n2', 15, 2)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet');
    }
};
