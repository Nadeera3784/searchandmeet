<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('person_name');
            $table->string('email');
            $table->string('phone')->default(null)->nullable();
            $table->string('website')->default(null)->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('looking_for')->nullable();
            $table->string('business_name');
            $table->text('business_description')->default(null)->nullable();
            $table->text('inquiry_message')->default(null)->nullable();
            $table->unsignedBigInteger('agent_id')->default(null)->nullable();
            $table->unsignedBigInteger('status')->default(1);

            $table->foreign('agent_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();

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
        Schema::dropIfExists('leads');
        Schema::enableForeignKeyConstraints();
    }
}
