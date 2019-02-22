<?php

namespace App\Providers;

use App\Models\Container;
use App\Models\MapLocation;
use App\Models\MapStructure;
use App\Models\User;
use App\Observers\ContainerObserver;
use App\Observers\MapLocationObserver;
use App\Observers\MapStructureObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        MapStructure::observe(MapStructureObserver::class);
        MapLocation::observe(MapLocationObserver::class);
        Container::observe(ContainerObserver::class);
        Resource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
