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
        Schema::create('customers_documents_and_videos', function (Blueprint $table) {
            $table->id(); 
            $table->bigInteger('job_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('employment_evidence')->nullable();
            $table->string('licences')->nullable();
            $table->string('kitchen_area')->nullable();
            $table->string('ingredients')->nullable();
            $table->string('cooking_tech')->nullable();
            $table->string('dish')->nullable();
            $table->string('clean_up')->nullable();
            $table->string('evidence_image')->nullable();
            $table->string('resume')->nullable();   
            $table->tinyInteger('is_australia')->default(0)->comments('0=no,1=yes');        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_documents_and_videos');
    }
};
