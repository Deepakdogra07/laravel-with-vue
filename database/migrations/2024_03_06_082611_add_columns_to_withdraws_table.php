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
        Schema::table('withdraws', function (Blueprint $table) {
            $table->string('bankcode')->nullable();
            $table->string('agency_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_cpf')->nullable();
            $table->string('cpf')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('through_email')->nullable();
            $table->string('randomkey')->nullable();
            $table->string('pixtype')->nullable();
            $table->string('isChecked')->default(false);
            $table->string('receiveLoanThrough')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdraws', function (Blueprint $table) {
            //
        });
    }
};
