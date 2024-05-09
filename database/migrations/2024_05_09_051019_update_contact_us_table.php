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
        if(Schema::hasTable('contactus')){
            Schema::table('contactus',function(Blueprint $table){
                if(Schema::hasColumn('contactus', 'user_message')) {
                    $table->longText('user_message')->change();
                };
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
