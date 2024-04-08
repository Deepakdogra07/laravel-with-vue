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
        Schema::create('interest_commission', function (Blueprint $table) {
            $table->id();
            $table->text('user_id');
            $table->decimal('commission', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('interest', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_commission');
    }
};
