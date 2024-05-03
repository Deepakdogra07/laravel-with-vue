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
        Schema::table('jobs', function (Blueprint $table) {
           $table->longText('job_description')->after('job_title')->nullable();
           $table->string('job_image')->after('job_description')->nullable();
           $table->string('job_country')->after('positions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('job_description');
            $table->dropColumn('job_image');
            $table->dropColumn('job_country');
        });
    }
};
