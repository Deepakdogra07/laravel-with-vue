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
            $table->string('numberOfmonths')->nullable();
            $table->string('receiveLoanThrough')->nullable();
            $table->string('pixKey')->nullable();
            $table->string('cardNumber')->nullable();
            $table->string('printedName')->nullable();
            $table->string('documentOption')->nullable();
            $table->string('ssnFrontPhoto')->nullable();
            $table->string('ssnBackPhoto')->nullable();
            $table->string('drivingLicense')->nullable();
            $table->string('dlFrontPhoto')->nullable();
            $table->string('dlBackPhoto')->nullable();
            $table->string('frontCardSelfie')->nullable();
            $table->string('backCardSelfie')->nullable();
            $table->string('backCardImage')->nullable();
            $table->string('cardLimitScreenshot')->nullable();
            $table->integer('limitAvailable')->nullable();
            $table->string('declarationCheckbox')->nullable();
            $table->string('referralLink')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn([
                'numberofinstallment', 'numberOfmonths', 'instalamount',
              'receiveLoanThrough', 'pixKey', 'cardNumber', 'printedName',
              'monthYear', 'documentOption', 'ssnFrontPhoto', 'ssnBackPhoto',
              'drivingLicense', 'dlFrontPhoto', 'dlBackPhoto', 'frontCardSelfie',
              'backCardSelfie', 'backCardImage', 'cardLimitScreenshot', 'limitAvailable',
              'declarationCheckbox', 'referralLink', 'created_at', 'updated_at',
          ]);
        });
    }
};
