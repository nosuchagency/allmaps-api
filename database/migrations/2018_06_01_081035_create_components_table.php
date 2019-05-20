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
            $table->increments('id');

            $table->string('name');
            $table->string('type')->default('plan');
            $table->string('shape')->default('polyline');
            $table->text('description')->nullable();

            $table->boolean('stroke')->default(true);
            $table->string('color')->default('#3388ff');
            $table->unsignedInteger('weight')->default(3);
            $table->decimal('opacity', 2, 1)->default(1.0);
            $table->boolean('dashed')->default(false);
            $table->string('dash_pattern')->default('5,3,2');
            $table->boolean('fill')->default(true);
            $table->string('fill_color')->default('#3388ff');
            $table->decimal('fill_opacity', 2, 1)->default(0.2);
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
        Schema::dropIfExists('components');
    }
}
