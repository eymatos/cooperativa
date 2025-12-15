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
    Schema::create('savings_accounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('socio_id')->constrained()->onDelete('cascade');
        $table->foreignId('saving_type_id')->constrained();
        
        // Saldo acumulado total
        $table->decimal('balance', 15, 2)->default(0); 
        
        // ESTO ES NUEVO: El monto que se le descontará automáticamente cada mes
        // Si el socio pide cambiar la cuota, actualizamos este campo.
        $table->decimal('recurring_amount', 15, 2)->default(0); 
        
        $table->unique(['socio_id', 'saving_type_id']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings_accounts');
    }
};
