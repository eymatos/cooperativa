<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prestamo_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->integer('numero_cuota'); // 1, 2, 3...
            
            // Desglose financiero
            $table->decimal('capital', 12, 2);
            $table->decimal('interes', 12, 2);
            $table->decimal('monto_total', 12, 2); // capital + interes
            
            $table->date('fecha_vencimiento');
            
            // Control de pagos
            $table->decimal('pagado', 12, 2)->default(0); // Cuánto ha abonado a esta cuota
            $table->string('estado')->default('pendiente'); // 'pendiente', 'parcial', 'pagada'

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};