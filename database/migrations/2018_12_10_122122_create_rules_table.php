<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('distance')->default('close');
            $table->string('weekday')->default('all');
            $table->integer('discovery_time')->nullable();

            $table->boolean('time_restricted')->default(false);
            $table->time('time_from')->nullable();
            $table->time('time_to')->nullable();

            $table->boolean('date_restricted')->default(false);
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();

            $table->string('push_title')->nullable();
            $table->string('push_body')->nullable();

            $table->unsignedBigInteger('beacon_container_id');
            $table->foreign('beacon_container_id')
                ->references('id')
                ->on('beacon_container')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}
