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
        Schema::create('video_intro_from_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('kitchen_area')->nullable();
            $table->string('ingredients')->nullable();
            $table->string('cooking_tech')->nullable();
            $table->string('dish')->nullable();
            $table->string('clean_up')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_intro_from_customers');
    }
};
