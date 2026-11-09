<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {

            // Tanggal tabung masuk
            $table->date('date_in')
                ->after('outlet_id');

            // Tekanan aktual tabung
            $table->decimal('tekanan', 12, 3)
                ->default(0)
                ->after('item');

            // Nomor tabung
            $table->string('no_tabung', 100)
                ->after('tekanan');

            // Nomor seri tabung
            $table->string('seri_tabung', 100)
                ->nullable()
                ->after('no_tabung');

            // Tanggal tabung selesai
            $table->date('date_end')
                ->nullable()
                ->after('seri_tabung');

            // Sales untuk 1 tabung
            $table->decimal('sales_tabung', 18, 2)
                ->default(0)
                ->after('date_end');
        });

        Schema::table('sales', function (Blueprint $table) {

            // Kolom lama sudah tidak digunakan
            $table->dropColumn([
                'qty_tabung',
                'total_sales',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {

            $table->decimal('qty_tabung', 12, 3)
                ->default(0);

            $table->decimal('total_sales', 18, 2)
                ->default(0);

            $table->dropColumn([
                'date_in',
                'tekanan',
                'no_tabung',
                'seri_tabung',
                'date_end',
                'sales_tabung',
            ]);
        });
    }
};
