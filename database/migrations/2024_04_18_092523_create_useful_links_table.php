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
        Schema::create('header_footer', function (Blueprint $table) {
            $table->id();
            $table->string('logo_image')->nullable();
            $table->text('logo_description')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('office_email')->nullable();
            $table->text('office_address')->nullable();
            $table->text('certificate_images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_footer');
    }
};
