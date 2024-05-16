<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requirements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('metric_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('requirement_specification_id')->nullable();

            $table->string('product');
            $table->text('description');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('url')->nullable();
            $table->string('pre_meeting_sample')->nullable();
            $table->string('trade_term')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('certification_requirement')->nullable();
            $table->string('hs_code')->nullable();

            $table->dateTime('target_purchase_date')->nullable();
            $table->string('purchase_frequency')->nullable();
            $table->string('purchase_policy')->nullable();
            $table->string('warranties_requirement')->nullable();
            $table->string('safety_standard')->nullable();

            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people');
            $table->foreign('metric_id')->references('id')->on('metrics');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('requirement_specification_id')->references('id')->on('files');

            $table->index(['person_id','created_at']);
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
        Schema::dropIfExists('purchase_requirements');
        Schema::enableForeignKeyConstraints();
    }
}
