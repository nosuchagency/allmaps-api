<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_fields', function (Blueprint $table) {
            $table->increments('id');

            $table->string('identifier');
            $table->string('type')->default('text');
            $table->string('value')->nullable();
            $table->string('label')->nullable();

            $table->unsignedInteger('location_id');
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

            $table->unsignedInteger('searchable_id');
            $table->foreign('searchable_id')
                ->references('id')
                ->on('searchables')
                ->onDelete('cascade');

            $table->unique(['identifier', 'location_id', 'searchable_id'], 'identifier_location_searchable_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_fields');
    }
}
