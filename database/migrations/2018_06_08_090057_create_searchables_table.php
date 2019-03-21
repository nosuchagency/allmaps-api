<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searchables', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('identifier')->unique();
            $table->boolean('activated')->default(false);

            $table->createdBy();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('searchables');
    }
}
