<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre completo (Indispensable)
            $table->string('cedula')->unique(); // Tu login
            $table->string('email')->nullable()->unique(); // Para notificaciones
            $table->string('password');
            $table->tinyInteger('tipo')->default(0); // 0: Socio, 1: Empleado, 2: Admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

