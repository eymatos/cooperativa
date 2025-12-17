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
        // Agregamos el salario. Usamos decimal para precisión de dinero.
        $table->decimal('salario', 12, 2)->default(0)->after('user_id');
    });
}

public function down(): void
{
    Schema::table('socios', function (Blueprint $table) {
        $table->dropColumn('salario');
    });
}
};
