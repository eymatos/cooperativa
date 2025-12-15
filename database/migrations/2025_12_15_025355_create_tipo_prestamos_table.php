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
    Schema::create('tipo_prestamos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');          // Ej: Escolar, Express
        $table->decimal('tasa_interes', 5, 2); // Ej: 12.00
        $table->integer('plazo_defecto')->nullable(); // Ej: 12 (meses). Null si es abierto.
        $table->timestamps();
    });

    // También debemos agregar la columna a la tabla de préstamos existente
    Schema::table('prestamos', function (Blueprint $table) {
        $table->foreignId('tipo_prestamo_id')->nullable()->after('socio_id')->constrained('tipo_prestamos');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_prestamos');
    }
};
