<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('outlet_id')
                ->constrained('outlet')
                ->cascadeOnDelete();

            $table->string('bulan', 20);

            $table->enum('item', [
                'ISI N2',
                'KOSONG'
            ]);

            $table->decimal('qty_tabung', 12, 3)->default(0);

            $table->decimal('total_sales', 18, 2)->default(0);


            $table->enum('keterangan', [
                'BELUM HABIS',
                'HABIS',
                'LANJUTAN',
                'KOSONG'
            ]);

            $table->text('catatan')->nullable();
            $table->string('nama_operator', 100);

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
