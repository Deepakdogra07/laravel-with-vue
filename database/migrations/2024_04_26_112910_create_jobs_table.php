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
            $table->integer('user_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('position_id')->nullable();
            $table->string('seniority_id')->nullable();
            $table->string('discipline_id')->nullable();
            $table->string('work_experience_id')->nullable();
            $table->string('skills_id')->nullable();
            $table->string('remote_work')->nullable();
            $table->string('industry_id')->nullable();
            $table->string('segment')->nullable();
            $table->string('positions')->nullable();
            $table->string('city')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('min_pay_range')->nullable();
            $table->string('max_pay_range')->nullable();
            $table->string('job_start_date')->nullable();
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
