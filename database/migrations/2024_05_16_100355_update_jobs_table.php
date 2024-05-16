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
       Schema::table('jobs',function(Blueprint $table){
        $table->string('posting_summary')->nullable();
        $table->string('detail')->nullable();
        $table->string('conditions')->nullable();
        $table->string('requirements')->nullable();
        $table->string('language_id')->nullable()->after('position_id');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs',function(Blueprint $table){
            $table->dropColumn('posting_summary');
            $table->dropColumn('detail');
            $table->dropColumn('conditions');
            $table->dropColumn('language_id');
            $table->dropColumn('requirements');
           });
    }
};
