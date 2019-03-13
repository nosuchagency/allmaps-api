<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_components', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('type')->default('plan');

            $table->text('description')->nullable();

            $table->string('shape')->default('polyline');
            $table->string('color')->default('#000000');
            $table->decimal('opacity', 2, 1)->default(1.0);
            $table->integer('weight')->default(2);
            $table->boolean('curved')->default(false);
            $table->string('image')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

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
        Schema::dropIfExists('map_components');
    }
}
