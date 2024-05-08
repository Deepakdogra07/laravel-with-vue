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
        if(Schema::hasTable('testimonials')){
            Schema::table('testimonials',function(Blueprint $table){
                if(Schema::hasColumn('testimonials', 'description')) {
                    $table->text('description')->change();
                };
            });
        }
        Schema::table('testimonials',function(Blueprint $table){
            $table->string('video_name')->after('video_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials',function(Blueprint $table){
            $table->dropColumn('video_name');
        });
    }
};
