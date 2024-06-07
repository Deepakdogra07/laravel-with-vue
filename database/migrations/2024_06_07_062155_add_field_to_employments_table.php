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
        Schema::table('customers_employments', function (Blueprint $table) {
            $table->string('evidence_self_employment_aus')->after('evidence_self_employment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers_employments', function (Blueprint $table) {
            $table->dropColumn('evidence_self_employment_aus');
        });
    }
};
