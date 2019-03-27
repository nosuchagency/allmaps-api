<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_structures', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();

            $table->longText('coordinates')->nullable();
            $table->longText('markers')->nullable();
            $table->decimal('radius', 8, 2)->nullable();

            $table->unsignedInteger('floor_id');
            $table->foreign('floor_id')
                ->references('id')
                ->on('floors')
                ->onDelete('cascade');

            $table->unsignedInteger('map_component_id');
            $table->foreign('map_component_id')
                ->references('id')
                ->on('map_components')
                ->onDelete('cascade');

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
        Schema::dropIfExists('map_structures');
    }
}
