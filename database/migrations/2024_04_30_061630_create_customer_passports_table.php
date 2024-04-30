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
        Schema::create('customer_passports', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('issuing_authority')->nullable();
            $table->string('date_of_expiry')->nullable();
            $table->string('more_passport')->default(0)->comment('0=no,1=yes');
            $table->string('visa_available')->default(0)->comment('0=no,1=yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_passports');
    }
};
