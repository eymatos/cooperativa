<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('savings_accounts', function (Blueprint $table) {
            // Agregamos la columna que falta
            $table->decimal('recurring_amount', 15, 2)->default(0)->after('balance');
        });
    }

    public function down(): void
    {
        Schema::table('savings_accounts', function (Blueprint $table) {
            $table->dropColumn('recurring_amount');
        });
    }
};