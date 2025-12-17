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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Quién lo hizo
        $table->string('action'); // 'crear', 'editar', 'eliminar'
        $table->string('model');  // 'Prestamo', 'Socio', etc.
        $table->unsignedBigInteger('model_id'); // ID del registro afectado
        $table->json('before')->nullable(); // Datos antes del cambio
        $table->json('after')->nullable();  // Datos después del cambio
        $table->string('ip_address')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
