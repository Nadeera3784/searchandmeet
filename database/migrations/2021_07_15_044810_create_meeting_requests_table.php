<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_requests', function (Blueprint $table) {
            $table->id();

            $table->text('message');
            $table->unsignedBigInteger('purchase_requirement_id');
            $table->unsignedBigInteger('person_id');
            $table->json('day_availability')->nullable()->default(null);
            $table->json('default_availability')->nullable()->default(null);
            $table->unsignedBigInteger('recommend_similar_products')->nullable()->default(0);
            $table->unsignedBigInteger('status')->default(0);

            $table->foreign('person_id')->references('id')->on('people')->cascadeOnDelete();
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
        Schema::dropIfExists('meeting_requests');
    }
}
