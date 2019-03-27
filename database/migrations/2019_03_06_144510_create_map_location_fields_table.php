<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapLocationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_location_fields', function (Blueprint $table) {
            $table->increments('id');

            $table->string('identifier');
            $table->string('type')->default('text');
            $table->string('value')->nullable();

            $table->unsignedInteger('map_location_id');
            $table->foreign('map_location_id')
                ->references('id')
                ->on('map_locations')
                ->onDelete('cascade');

            $table->unsignedInteger('searchable_id');
            $table->foreign('searchable_id')
                ->references('id')
                ->on('searchables')
                ->onDelete('cascade');

            $table->unique(['identifier', 'map_location_id', 'searchable_id'], 'identifier_map_location_searchable_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_location_fields');
    }
}
