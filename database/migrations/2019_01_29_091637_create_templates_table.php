<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('hook')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('activated')->default(false);

            $table->unsignedInteger('layout_id')->nullable();
            $table->foreign('layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('set null');

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
        Schema::dropIfExists('templates');
    }
}
