<?php

namespace App\Providers;

use App\Models\Container;
use App\Models\Skin;
use App\MorphMap;
use App\Observers\ContainerObserver;
use App\Observers\SkinObserver;
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
        Skin::observe(SkinObserver::class);

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

    }
}
