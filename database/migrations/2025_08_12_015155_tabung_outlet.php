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
        Schema::create('tabung_outlet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tabung_id')->constrained('tabung')->onDelete('cascade');
            $table->foreignId('outlet_id')->constrained('outlet')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabung_outlet');
    }
};
