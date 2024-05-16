<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('purchase_requirement_id');
            $table->tinyInteger('type')->default(\App\Enums\Order\OrderItemType::MeetingWithHost);
            $table->unsignedBigInteger('timeslot_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('purchase_requirement_id')->references('id')->on('purchase_requirements')->cascadeOnDelete();
            $table->foreign('timeslot_id')->references('id')->on('timeslots');

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
        Schema::dropIfExists('order_items');
        Schema::enableForeignKeyConstraints();
    }
}
