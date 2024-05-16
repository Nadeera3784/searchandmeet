<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('company_type_id');

            $table->string('name');
            $table->string('current_importer')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();

            $table->string('founded_year')->nullable();
            $table->string('HQ')->nullable();
            $table->unsignedBigInteger('employee_count')->nullable();
            $table->string('annual_revenue')->nullable();
            //$table->string('sic_code')->nullable();
            //$table->string('naics_code')->nullable();

            $table->string('address');
            $table->string('city');
            $table->string('state');

            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('country_id')->references('id')->on('countries');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('businesses');
        Schema::enableForeignKeyConstraints();
    }
}
