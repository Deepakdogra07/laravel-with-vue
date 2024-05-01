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
        Schema::create('customer_additional_details', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('travel_details')->nullable();
            $table->string('purpose_of_stay')->nullable();
            $table->string('tourism')->nullable();
            $table->string('business')->nullable();
            $table->string('transit')->nullable();
            $table->string('type_of_visa')->nullable();
            $table->string('skilled_visa')->nullable()->comment('consultation');
            $table->string('option_visa')->nullable();
            $table->string('partner_visa')->nullable()->comment('consultation');
            $table->string('investor_visa')->nullable()->comment('consultation');
            $table->string('other')->nullable()->comment('consultation');
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
        Schema::dropIfExists('customer_additional_details');
    }
};
