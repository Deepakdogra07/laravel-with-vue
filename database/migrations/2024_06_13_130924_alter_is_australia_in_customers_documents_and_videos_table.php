<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIsAustraliaInCustomersDocumentsAndVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers_documents_and_videos', function (Blueprint $table) {
            $table->string('is_australia', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers_documents_and_videos', function (Blueprint $table) {
            // Assuming the previous type was boolean, change it back to boolean
            // Adjust this according to the original data type
            $table->boolean('is_australia')->change();
        });
    }
}
