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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('position_type')->nullable();
            $table->string('seniority')->nullable();
            $table->string('discipline')->nullable();
            $table->string('work_experience')->nullable();
            $table->string('skills')->nullable();
            $table->string('remote_work')->nullable();
            $table->string('industry')->nullable();
            $table->string('segment')->nullable();
            $table->string('positions')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pay_range')->nullable();
            $table->string('job_start_date')->nullable();
            $table->string('application_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
