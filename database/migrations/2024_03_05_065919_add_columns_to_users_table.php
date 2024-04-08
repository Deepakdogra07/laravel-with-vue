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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('through_email')->nullable();
            $table->string('randomkey')->nullable();
            $table->string('bankcode')->nullable();
            $table->string('agency_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_cpf')->nullable();
            $table->string('isChecked')->nullable()->default(0);
            $table->string('receiveLoanThrough')->nullable()->default(0);
            // $table->string('pixtype')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cpf');
            $table->dropColumn('phonenumber');
            $table->dropColumn('through_email');
            $table->dropColumn('randomkey');
            $table->dropColumn('bankcode');
            $table->dropColumn('agency_number');
            $table->dropColumn('account_number');
            $table->dropColumn('bank_cpf');
            $table->dropColumn('isChecked');
            $table->dropColumn('receiveLoanThrough');
        });
    }
};
