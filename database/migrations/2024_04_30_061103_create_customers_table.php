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
        Schema::create('customers_personal_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('confirm_email')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('country_of_birth')->nullable();
            $table->string('city_of_birth')->nullable();
            $table->string('martial_status')->nullable();
            $table->string('gender')->nullable();
            $table->string('migrate_country')->nullable();
            $table->string('customer_image')->nullable();
            $table->string('passport_image')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('issuing_authority')->nullable();
            $table->string('date_of_expiry')->nullable();
            $table->tinyInteger('citizen_of_more_than_one_country')->default(0)->comment('0=no,1=yes');
            $table->tinyInteger('visa_available')->default(0)->comment('0=no,1=yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_personal_details');
    }
};
