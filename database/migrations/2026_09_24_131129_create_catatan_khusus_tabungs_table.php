<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_khusus_tabungs', function (Blueprint $table) {
            $table->id();

            $table->string('kode_tabung');

            $table->foreignId('outlet_id')
                ->constrained('outlet')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('catatan');

            $table->timestamps();

            $table->index(['kode_tabung', 'outlet_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_khusus_tabungs');
    }
};
