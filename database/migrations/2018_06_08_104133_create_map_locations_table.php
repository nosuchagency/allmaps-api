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

            $table->string('name')->nullable();
            $table->unsignedInteger('zoom_from')->default(0);
            $table->unsignedInteger('zoom_to')->default(30);
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('search_activated')->default(true);
            $table->string('search_text')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('publish_at')->nullable();
            $table->dateTime('unpublish_at')->nullable();

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

            $table->unsignedInteger('fixture_id')->nullable();
            $table->foreign('fixture_id')
                ->references('id')
                ->on('fixtures')
                ->onDelete('cascade');

            $table->unsignedInteger('beacon_id')->nullable();
            $table->foreign('beacon_id')
                ->references('id')
                ->on('beacons')
                ->onDelete('cascade');

            $table->longText('coordinates')->nullable();

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
