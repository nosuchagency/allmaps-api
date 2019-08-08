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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('identifier')->unique()->nullable();
            $table->text('description')->nullable();

            $table->string('proximity_uuid')->nullable();
            $table->integer('major')->nullable();
            $table->integer('minor')->nullable();

            $table->string('namespace')->nullable();
            $table->string('instance_id')->nullable();
            $table->string('url')->nullable();

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
