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
        Schema::create('jobs_with_customer_status',function(Blueprint $table){
            $table->id();
            $table->bigInteger('job_id');
            $table->bigInteger('customer_id');
            $table->tinyInteger('status')->comment('0=applied,1=awaiting_review,2=reviewed,3=contacted,4=hired,5=rejected')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_with_customer_status');
    }
};
