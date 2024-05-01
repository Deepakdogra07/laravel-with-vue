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
        Schema::create('customer_travel_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('travel_details')->nullable();
            $table->string('purpose_of_stay')->nullable();
            $table->string('type_of_visa')->nullable();
            $table->string('date_of_travel')->nullable();
            $table->string('passenger_nationality')->nullable();
            $table->string('port_of_arrival')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_travel_details');
    }
};
