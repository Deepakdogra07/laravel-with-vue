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
        Schema::create('customers_employments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('employer_statement')->nullable();
            $table->string('financial_evidence')->nullable();
            $table->string('evidence_self_employment')->nullable();
            $table->string('formal_training_evidence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_employments');
    }
};
