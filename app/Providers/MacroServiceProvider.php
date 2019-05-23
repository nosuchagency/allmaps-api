<?php

namespace App\Providers;

use App\Models\Container;
use App\Models\User;
use App\Observers\ContainerObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any macros.
     *
     * @return void
     */
    public function boot()
    {
        $this->blueprintMacros();
    }

    /**
     * Blueprint macros
     *
     * @return void
     */
    protected function blueprintMacros()
    {
        Blueprint::macro('createdBy', function () {
            $this->unsignedBigInteger('created_by')->nullable();

            $this->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Blueprint::macro('category', function () {
            $this->unsignedBigInteger('category_id')->nullable();

            $this->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null');
        });

        Blueprint::macro('tag', function () {
            $this->unsignedBigInteger('tag_id')->nullable();

            $this->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });
    }
}
