<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstagramTwitterColumnToBusinessesTable extends Migration{

    public function up(){
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
        });
    }


    public function down(){

    }
}
