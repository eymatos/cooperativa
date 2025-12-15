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
        Schema::create('saving_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ejemplo: "Aportaciones", "Ahorro Retirable"
            $table->string('code')->unique(); // Ejemplo: 'APO', 'RET'
            $table->boolean('allow_withdrawals')->default(false); // ¿Se puede retirar hoy día?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_types');
    }
};
