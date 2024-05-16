<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequirementsAddLookingToMeet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requirements', function (Blueprint $table) {
            $table->unsignedBigInteger('looking_to_meet')->default(null)->nullable();
            $table->unsignedBigInteger('looking_from')->default(null)->nullable();

            $table->dropColumn('payment_term');
            $table->dropColumn('trade_term');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_requirements', function (Blueprint $table) {
            //
        });
    }
}
