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
        Schema::table('savings_accounts', function (Blueprint $table) {
    $table->timestamp('manual_change_at')->nullable(); // Este campo solo cambiará cuando uses el lápiz
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('savings_accounts', function (Blueprint $table) {
            //
        });
    }
};
