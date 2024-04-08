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
        Schema::table('contacts_details', function (Blueprint $table) {
            $table->string('facebookurl')->after('address')->nullable();
            $table->string('twitterurl')->after('facebookurl')->nullable();
            $table->string('instagramurl')->after('twitterurl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts_details', function (Blueprint $table) {
            $table->dropColumn(['facebookurl', 'twitterurl', 'instagramurl']);
        });
    }
};
