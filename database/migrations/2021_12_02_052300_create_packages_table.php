<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('allowed_meeting_count');
            $table->unsignedBigInteger('quota_used')->default(0);
            $table->unsignedFloat('discount_rate')->default(0);
            $table->unsignedBigInteger('country_id')->default(null)->nullable();
            $table->unsignedBigInteger('status')->default(0);
            $table->string('payment_link')->nullable()->default(null);

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
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
        Schema::dropIfExists('packages');
    }
}
