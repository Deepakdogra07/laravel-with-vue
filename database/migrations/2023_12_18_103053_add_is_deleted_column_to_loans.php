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
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('is_deleted')->default(0)->after('documents_id');
            $table->integer('assigned_to')->default(0)->after('documents_id');
            $table->integer('created_by')->default(0)->after('documents_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
            $table->dropColumn('created_by');
            $table->dropColumn('assigned_to');

        });
    }
};
