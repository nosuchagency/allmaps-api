<?php

namespace App\Providers;

use App\Models\Container;
use App\Models\Skin;
use App\Models\User;
use App\Observers\ContainerObserver;
use App\Observers\SkinsObserver;
use App\Observers\UserObserver;
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
