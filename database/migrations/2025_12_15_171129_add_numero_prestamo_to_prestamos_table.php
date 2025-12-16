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
    Schema::table('prestamos', function (Blueprint $table) {
        // Agregamos la columna 'numero_prestamo' que puede ser nula al principio
        $table->string('numero_prestamo', 20)->nullable()->after('id');
    });
}

public function down(): void
{
    Schema::table('prestamos', function (Blueprint $table) {
        $table->dropColumn('numero_prestamo');
    });
}
};
