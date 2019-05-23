<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('type')->default('plan');
            $table->string('shape')->default('polyline');
            $table->text('description')->nullable();

            $table->boolean('stroke')->default(true);
            $table->string('stroke_type')->default('solid');
            $table->string('stroke_color')->default('#3388ff');
            $table->unsignedInteger('stroke_width')->default(3);
            $table->decimal('stroke_opacity', 2, 1)->default(1.0);
            $table->boolean('fill')->default(true);
            $table->string('fill_color')->default('#3388ff');
            $table->decimal('fill_opacity', 2, 1)->default(0.2);
            $table->string('image')->nullable();
            $table->unsignedInteger('image_width')->nullable();
            $table->unsignedInteger('image_height')->nullable();

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
        Schema::dropIfExists('components');
    }
}
