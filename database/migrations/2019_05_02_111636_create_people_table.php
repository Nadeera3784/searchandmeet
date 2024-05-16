<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('designation')->nullable();
            $table->unsignedBigInteger('status')->default(\App\Enums\Person\AccountStatus::OnBoarding);
            $table->unsignedBigInteger('timezone_id');

            $table->string('name');
            $table->string('email')->unique();

            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('phone_number')->nullable();

            $table->timestamp('phone_verified_at')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('looking_for')->nullable();
            $table->string('password')->nullable();

            $table->foreign('agent_id')->references('id')->on('users');
            $table->foreign('timezone_id')->references('id')->on('timezones');
            $table->foreign('country_id')->references('id')->on('countries');

            $table->rememberToken();

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
        Schema::dropIfExists('people');
        Schema::enableForeignKeyConstraints();
    }
}
