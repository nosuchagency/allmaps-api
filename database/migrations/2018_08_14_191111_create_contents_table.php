<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->longText('text')->nullable();
            $table->text('url')->nullable();
            $table->text('yt_url')->nullable();

            $table->unsignedBigInteger('folder_id');
            $table->foreign('folder_id')
                ->references('id')
                ->on('folders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('content_id')->nullable();
            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade');

            $table->integer('order')->nullable();

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
        Schema::dropIfExists('contents');
    }
}
