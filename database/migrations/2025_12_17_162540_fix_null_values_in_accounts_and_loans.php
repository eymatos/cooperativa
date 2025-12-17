<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Limpiar la tabla de Cuentas de Ahorro
        // Primero convertimos los NULL existentes en 0
        DB::table('savings_accounts')->whereNull('recurring_amount')->update(['recurring_amount' => 0]);

        Schema::table('savings_accounts', function (Blueprint $table) {
            $table->decimal('recurring_amount', 15, 2)->default(0.00)->change();
        });

        // 2. Limpiar la tabla de Cuotas de Préstamos
        // Convertimos capital e interés NULL en 0
        DB::table('cuotas')->whereNull('capital')->update(['capital' => 0]);
        DB::table('cuotas')->whereNull('interes')->update(['interes' => 0]);

        Schema::table('cuotas', function (Blueprint $table) {
            $table->decimal('capital', 15, 2)->default(0.00)->change();
            $table->decimal('interes', 15, 2)->default(0.00)->change();
        });
    }

    public function down(): void
    {
        // No solemos revertir a NULL por seguridad de data
    }
};