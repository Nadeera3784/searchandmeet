<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaicNaicToBusinessTable extends Migration
{

    public function up(){
        Schema::table('businesses', function (Blueprint $table) {
            $table->unsignedBigInteger('sic_code')->nullable();
            $table->unsignedBigInteger('naics_code')->nullable();
            $table->foreign('sic_code')->references('id')->on('saic_codes');
            $table->foreign('naics_code')->references('id')->on('naic_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        // Schema::table('business', function (Blueprint $table) {
        //     //
        // });
    }
}
