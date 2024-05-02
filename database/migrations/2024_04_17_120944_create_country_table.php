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
        Schema::table('home_page', function (Blueprint $table) {
            $table->string('country_description')->nullable();
            $table->string('country_1_name')->nullable();
            $table->string('country_1_image')->nullable();
            $table->string('country_2_name')->nullable();
            $table->string('country_2_image')->nullable();
            $table->string('video_heading')->nullable();
            $table->string('video_subheading')->nullable();
            $table->string('video_description')->nullable();
            $table->string('video_introduction')->nullable();
            $table->string('category_heading')->nullable();
            $table->text('category_subheading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page', function (Blueprint $table) {
            $table->dropColumn('country_description');
            $table->dropColumn('country_1_name');
            $table->dropColumn('country_1_image');
            $table->dropColumn('country_2_name');
            $table->dropColumn('country_2_image');
            $table->dropColumn('video_heading');
            $table->dropColumn('video_subheading');
            $table->dropColumn('video_description');
            $table->dropColumn('video_introduction');
            $table->dropColumn('category_heading');
            $table->dropColumn('category_subheading');
        });
    
    }
};
