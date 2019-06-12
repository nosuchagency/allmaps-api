<?php

namespace App\Providers;

use App\Models\Beacon;
use App\Models\Category;
use App\Models\Container;
use App\Models\Fixture;
use App\Models\Location;
use App\Models\Poi;
use App\Models\Skin;
use App\Models\Tag;
use App\Models\User;
use App\MorphMap;
use App\Observers\ContainerObserver;
use App\Observers\SkinsObserver;
use App\Observers\UserObserver;
use App\Pivots\BeaconContainer;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Container::observe(ContainerObserver::class);
        Skin::observe(SkinsObserver::class);
        User::observe(UserObserver::class);

        Resource::withoutWrapping();

        Relation::morphMap(MorphMap::MAP);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
