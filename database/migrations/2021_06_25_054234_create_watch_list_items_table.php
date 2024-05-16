<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_list_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('watch_list_id');
            $table->unsignedBigInteger('purchase_requirement_id');

            $table->foreign('watch_list_id')->references('id')->on('watch_lists')->cascadeOnDelete();
            $table->foreign('purchase_requirement_id')->references('id')->on('purchase_requirements')->cascadeOnDelete();
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
        Schema::dropIfExists('watch_list_items');
    }
}
