<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeaconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();

            // iBeacon fields
            $table->string('proximity_uuid')->nullable();
            $table->integer('major')->nullable();
            $table->integer('minor')->nullable();

            // Eddystone fields
            $table->string('eddystone_uid')->nullable();
            $table->string('eddystone_url')->nullable();
            $table->string('eddystone_tlm')->nullable();
            $table->string('eddystone_eid')->nullable();

            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->unsignedInteger('floor_id')->nullable();
            $table->foreign('floor_id')
                ->references('id')
                ->on('floors')
                ->onDelete('set null');

            $table->category();
            $table->createdBy();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beacons');
    }
}
