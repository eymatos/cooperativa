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
    Schema::create('solicitudes', function (Blueprint $table) {
        $table->id();
        // user_id es opcional (null) para nuevos socios que aún no tienen cuenta
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('tipo'); // Ejemplo: 'inscripcion', 'prestamo', 'retiro'
        $table->json('datos'); // Aquí se guardarán todos los campos que el socio llene
        $table->string('estado')->default('pendiente'); // pendiente, procesada, rechazada
        $table->text('comentarios_admin')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
