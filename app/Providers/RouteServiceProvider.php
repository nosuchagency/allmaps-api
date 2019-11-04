<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapTokenRoutes();
        $this->mapUserRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::namespace($this->namespace)
            ->middleware(['web'])
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "user" routes for the application.
     *
     * @return void
     */
    protected function mapUserRoutes()
    {
        Route::prefix('v1/user')
            ->middleware(['api', 'auth'])
            ->group(base_path('routes/api/v1/crud.php'));

        Route::prefix('v1/user')
            ->middleware(['api'])
            ->group(base_path('routes/api/v1/misc.php'));
    }

    /**
     * Define the "token" routes for the application.
     *
     * @return void
     */
    protected function mapTokenRoutes()
    {
        Route::prefix('v1/token')
            ->middleware(['api', 'auth:token'])
            ->group(base_path('routes/api/v1/crud.php'));
    }
}
