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
    Schema::table('cuotas', function (Blueprint $table) {
        // Agregamos columna para saber cuánto se ha pagado de ESTA cuota
        $table->decimal('abonado', 10, 2)->default(0)->after('monto_total');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuotas', function (Blueprint $table) {
            //
        });
    }
};
