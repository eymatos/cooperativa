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
        Schema::create('gasto_administrativos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->decimal('monto', 15, 2);
            $table->date('fecha');
            
            // Categorías corregidas y detalladas
            $table->enum('categoria', [
                'bancario', 
                'nomina', 
                'servicios_web', 
                'redes_sociales', 
                'comida_eventos',      // Para almuerzos/meriendas de socios
                'rifas_navidad',       // Para las rifas anuales
                'incentivos_directivos',
                'otros'
            ])->default('otros');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gasto_administrativos');
    }
};
