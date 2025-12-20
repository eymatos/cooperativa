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
    Schema::create('cierre_anuals', function (Blueprint $table) {
        $table->id();
        $table->integer('anio')->unique();
        $table->decimal('excedente_bruto', 15, 2);
        $table->decimal('reserva_legal', 15, 2);
        $table->decimal('reserva_educacion', 15, 2);
        $table->decimal('excedente_neto', 15, 2);
        $table->integer('pct_capitalizacion')->default(50);
        $table->integer('pct_patrocinio')->default(50);
        $table->foreignId('user_id')->constrained(); // Quién cerró el año
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_anuals');
    }
};
