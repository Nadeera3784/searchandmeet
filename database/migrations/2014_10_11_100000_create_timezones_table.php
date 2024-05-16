<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimezonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timezones', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2);
            $table->string('name');
            $table->float('gmt_offset', 10, 2);
            $table->float('dst_offset', 10, 2);
            $table->float('raw_offset', 10, 2);

            // $table->timestamps();

            $table->index('code');
            $table->index('name');
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
        Schema::dropIfExists('timezones');
        Schema::enableForeignKeyConstraints();
    }
}
