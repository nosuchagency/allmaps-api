<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

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
            ->namespace($this->namespace . '\API\V1')
            ->group(base_path('routes/api/v1/crud.php'));

        Route::prefix('v1/user')
            ->middleware(['api'])
            ->namespace($this->namespace . '\API\V1')
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
            ->namespace($this->namespace . '\API\V1')
            ->group(base_path('routes/api/v1/crud.php'));
    }
}
