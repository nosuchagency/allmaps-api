<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTableBetweenBeaconAndContainer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacon_container', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('beacon_id');
            $table->foreign('beacon_id')
                ->references('id')
                ->on('beacons')
                ->onDelete('cascade');

            $table->unsignedInteger('container_id');
            $table->foreign('container_id')
                ->references('id')
                ->on('content_containers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beacon_container');
    }
}
