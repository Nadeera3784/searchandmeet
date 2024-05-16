<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequirementsHsCodesTable extends Migration{

    public function up()
    {
        Schema::create('purchase_requirements_hs_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_requirement_id');
            $table->foreign('purchase_requirement_id')->references('id')->on('purchase_requirements')->cascadeOnDelete();
            $table->unsignedBigInteger('hs_code_id');
            $table->foreign('hs_code_id')->references('id')->on('hs_codes');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('purchase_requirements_hs_codes');
    }
}
