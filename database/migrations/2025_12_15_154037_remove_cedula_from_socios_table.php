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
    Schema::table('socios', function (Blueprint $table) {
        $table->dropColumn('cedula'); // 👈 Borramos la columna
    });
}

public function down(): void
{
    Schema::table('socios', function (Blueprint $table) {
        $table->string('cedula', 20)->nullable()->after('apellidos'); // Restaurar si algo sale mal
    });
}
};
