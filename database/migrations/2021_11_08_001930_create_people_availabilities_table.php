<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_availabilities', function (Blueprint $table) {
            $table->unsignedBigInteger('person_id')->unique()->index();
            $table->boolean('today');
            $table->boolean('tomorrow');
            $table->boolean('this_week');
            $table->boolean('this_month');
            $table->boolean('next_month');
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
        Schema::dropIfExists('people_availabilities');
    }
}
