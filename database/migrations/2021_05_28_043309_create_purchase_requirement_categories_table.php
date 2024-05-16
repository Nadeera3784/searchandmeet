<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequirementCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requirement_categories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('purchase_requirement_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('purchase_requirement_id')->references('id')->on('purchase_requirements');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_requirement_categories');
    }
}
