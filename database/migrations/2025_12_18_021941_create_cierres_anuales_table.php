<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cierres_anuales', function (Blueprint $table) {
            $table->id();
            $table->year('anio')->unique();
            $table->decimal('excedente_bruto', 15, 2);
            $table->decimal('reserva_legal', 15, 2);     
            $table->decimal('reserva_educacion', 15, 2); 
            $table->decimal('excedente_neto', 15, 2);    
            $table->decimal('pct_capitalizacion', 5, 2); 
            $table->decimal('pct_patrocinio', 5, 2);     
            $table->foreignId('user_id')->constrained(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cierres_anuales');
    }
};