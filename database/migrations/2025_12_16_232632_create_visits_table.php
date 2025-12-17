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
    Schema::create('visits', function (Blueprint $table) {
        $table->id();
        // Relacionamos con el usuario que entra al sistema
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('ip_address')->nullable();
        $table->string('user_agent')->nullable(); // Guarda si entró desde Chrome, Safari, móvil, etc.
        $table->timestamps(); // Esto nos da la fecha y hora exacta (created_at)
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
