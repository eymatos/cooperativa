<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();

            // Relación con el Socio
            $table->foreignId('socio_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Datos financieros (DECIMAL es obligatorio para dinero, nunca FLOAT)
            $table->decimal('monto', 12, 2);
            $table->decimal('tasa_interes', 5, 2); // Ejemplo: 12.50 %
            $table->integer('plazo'); // Cantidad de cuotas

            // Saldos (para no recalcular todo el tiempo)
            $table->decimal('saldo_capital', 12, 2)->default(0);

            // Fechas y Estado
            $table->date('fecha_solicitud');
            $table->date('fecha_inicio')->nullable();

            // 'pendiente', 'activo', 'pagado', 'rechazado'
            $table->string('estado')->default('pendiente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
