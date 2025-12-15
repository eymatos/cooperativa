<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // TUS CAMPOS ORIGINALES
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono');
            $table->text('direccion');
            $table->decimal('ahorro_total', 15, 2)->default(0);

            // --- CAMPOS NUEVOS RECOMENDADOS (Para evaluar préstamos) ---
            $table->decimal('sueldo', 12, 2)->default(0); // Capacidad de pago
            $table->string('lugar_trabajo')->nullable();  // Estabilidad laboral

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};