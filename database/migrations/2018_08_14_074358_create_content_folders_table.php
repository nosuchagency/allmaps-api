<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('primary')->default(false);

            $table->unsignedInteger('container_id');
            $table->foreign('container_id')
                ->references('id')
                ->on('content_containers')
                ->onDelete('cascade');

            $table->unsignedInteger('order')->nullable();

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
        Schema::dropIfExists('content_folders');
    }
}
