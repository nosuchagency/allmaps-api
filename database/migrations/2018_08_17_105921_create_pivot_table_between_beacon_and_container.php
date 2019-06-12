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
            $table->bigIncrements('id');

            $table->unsignedBigInteger('beacon_id');
            $table->foreign('beacon_id')
                ->references('id')
                ->on('beacons')
                ->onDelete('cascade');

            $table->unsignedBigInteger('container_id');
            $table->foreign('container_id')
                ->references('id')
                ->on('containers')
                ->onDelete('cascade');

            $table->unique(['beacon_id', 'container_id']);

            $table->createdBy();
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
        Schema::dropIfExists('beacon_container');
    }
}
