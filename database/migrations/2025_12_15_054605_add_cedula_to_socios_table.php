<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            // Agregamos la columna cédula después de apellidos
            // La ponemos 'nullable' para que no de error con los registros que ya existen
            $table->string('cedula', 20)->nullable()->after('apellidos');
        });
    }

    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            $table->dropColumn('cedula');
        });
    }
};