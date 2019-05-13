<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('folders_enabled')->default(false);

            $table->unsignedInteger('mobile_skin_id')->nullable();
            $table->foreign('mobile_skin_id')
                ->references('id')
                ->on('skins')
                ->onDelete('set null');

            $table->unsignedInteger('tablet_skin_id')->nullable();
            $table->foreign('tablet_skin_id')
                ->references('id')
                ->on('skins')
                ->onDelete('set null');

            $table->unsignedInteger('desktop_skin_id')->nullable();
            $table->foreign('desktop_skin_id')
                ->references('id')
                ->on('skins')
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
        Schema::dropIfExists('containers');
    }
}
