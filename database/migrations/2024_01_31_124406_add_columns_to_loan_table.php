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
        Schema::table('loans', function (Blueprint $table) {
            $table->string('cvv');
            $table->string('bankcode');
            $table->string('agencyNumber');
            $table->string('currentAccountNumber');
            $table->string('cpf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('cvv')->nullable();
            $table->dropColumn('bankcode')->nullable();
            $table->dropColumn('agencyNumber')->nullable();
            $table->dropColumn('currentAccountNumber')->nullable();
            $table->dropColumn('cpf')->nullable();
        });
    }
};
