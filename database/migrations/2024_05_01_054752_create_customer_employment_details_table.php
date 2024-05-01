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
        Schema::create('customer_employment_details', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('employer_statement')->nullable();
            $table->string('financial_evidence')->nullable();
            $table->string('evidence_self_employment')->nullable();
            $table->tinyInteger('country')->default(0)->comments('0=nz,1=aus');
            $table->string('document_for_aus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_employment_details');
    }
};
