<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_locations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('floor_id');
            $table->foreign('floor_id')
                ->references('id')
                ->on('floors')
                ->onDelete('cascade');

            $table->unsignedInteger('poi_id')->nullable();
            $table->foreign('poi_id')
                ->references('id')
                ->on('pois')
                ->onDelete('cascade');

            $table->unsignedInteger('findable_id')->nullable();
            $table->foreign('findable_id')
                ->references('id')
                ->on('findables')
                ->onDelete('cascade');

            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->text('area')->nullable();

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
        Schema::dropIfExists('map_locations');
    }
}
