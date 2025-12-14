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
    Schema::create('pagos', function (Blueprint $table) {
        $table->id();
        
        // Relación con el Préstamo
        $table->foreignId('prestamo_id')->constrained();
        
        // Opcional: Quién recibió el dinero (cajero)
        $table->foreignId('user_id')->constrained(); 

        $table->decimal('monto', 12, 2);
        $table->date('fecha_pago');
        $table->string('referencia')->nullable(); // Num recibo, transferencia, etc.
        $table->string('metodo')->default('efectivo'); // efectivo, transferencia
        
        $table->text('nota')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
