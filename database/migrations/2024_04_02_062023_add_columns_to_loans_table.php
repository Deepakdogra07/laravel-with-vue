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
            $table->string('cal_emi')->nullable();
            $table->string('cal_total_interest')->nullable();
            $table->string('cal_total_payment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('cal_emi');
            $table->dropColumn('cal_total_interest');
            $table->dropColumn('cal_total_payment');
        });
    }
};
