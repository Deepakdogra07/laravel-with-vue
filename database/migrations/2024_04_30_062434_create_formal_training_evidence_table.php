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
        Schema::create('customers_formal_training_evidences', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('evidence_image')->nullable();
            $table->string('skills')->nullable();
            $table->string('experience')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_formal_training_evidences');
    }
};
