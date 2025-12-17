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
        // Al quitar el ->after(...), SQL la pondrá al final de la tabla por defecto
        $table->string('tipo_contrato')->default('fijo'); 
    });
}

public function down(): void
{
    Schema::table('socios', function (Blueprint $table) {
        $table->dropColumn('tipo_contrato');
    });
}
};
