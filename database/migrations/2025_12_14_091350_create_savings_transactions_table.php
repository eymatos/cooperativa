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
        Schema::create('savings_transactions', function (Blueprint $table) {
            $table->id();
            
            // A qué cuenta pertenece este movimiento
            $table->foreignId('savings_account_id')->constrained();
            
            // Tipo de movimiento: Depósito, Retiro o Interés ganado
            $table->enum('type', ['deposit', 'withdrawal', 'interest']);
            
            // Monto de la transacción
            $table->decimal('amount', 15, 2);
            
            // Fecha real del movimiento (Aquí pondremos las fechas viejas: 2011-01-31, etc.)
            $table->date('date'); 
            
            // Aquí guardaremos los "comentarios_enero", etc.
            $table->string('description')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings_transactions');
    }
};
