<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_items', function (Blueprint $table) {
            $table->unsignedBigInteger('match_id')->index();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('item_type');

            $table->foreign('match_id')->references('id')->on('matches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_items');
    }
}
