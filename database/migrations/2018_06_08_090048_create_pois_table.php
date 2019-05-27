<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pois', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->nullable();

            $table->string('image')->nullable();

            $table->boolean('stroke')->default(true);
            $table->string('stroke_type')->default('solid');
            $table->string('stroke_color')->default('#3388ff');
            $table->unsignedInteger('stroke_width')->default(3);
            $table->decimal('stroke_opacity', 2, 1)->default(1.0);
            $table->boolean('fill')->default(true);
            $table->string('fill_color')->default('#3388ff');
            $table->decimal('fill_opacity', 2, 1)->default(0.2);

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
        Schema::dropIfExists('pois');
    }
}
