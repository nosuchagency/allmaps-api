<?php

use App\Http\Controllers\API\V1\ActivitiesController;
use App\Http\Controllers\API\V1\BeaconContainersController;
use App\Http\Controllers\API\V1\BeaconProvidersController;
use App\Http\Controllers\API\V1\BeaconsController;
use App\Http\Controllers\API\V1\BuildingsController;
use App\Http\Controllers\API\V1\CategoriesController;
use App\Http\Controllers\API\V1\ComponentsController;
use App\Http\Controllers\API\V1\ContainerBeaconsController;
use App\Http\Controllers\API\V1\ContainerLocationsController;
use App\Http\Controllers\API\V1\ContainersController;
use App\Http\Controllers\API\V1\ContentsController;
use App\Http\Controllers\API\V1\FilesController;
use App\Http\Controllers\API\V1\FixturesController;
use App\Http\Controllers\API\V1\FloorsController;
use App\Http\Controllers\API\V1\FoldersController;
use App\Http\Controllers\API\V1\HitsController;
use App\Http\Controllers\API\V1\ImportsController;
use App\Http\Controllers\API\V1\LayoutsController;
use App\Http\Controllers\API\V1\LocationsController;
use App\Http\Controllers\API\V1\MenuItemsController;
use App\Http\Controllers\API\V1\MenusController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\PermissionsController;
use App\Http\Controllers\API\V1\PlacesController;
use App\Http\Controllers\API\V1\PluginsController;
use App\Http\Controllers\API\V1\PoisController;
use App\Http\Controllers\API\V1\RolesController;
use App\Http\Controllers\API\V1\RulesController;
use App\Http\Controllers\API\V1\SearchController;
use App\Http\Controllers\API\V1\SkinsController;
use App\Http\Controllers\API\V1\StructuresController;
use App\Http\Controllers\API\V1\TagsController;
use App\Http\Controllers\API\V1\TemplatesController;
use App\Http\Controllers\API\V1\TokensController;
use App\Http\Controllers\API\V1\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/search', SearchController::class)->name('search');
Route::get('/plugins', PluginsController::class)->name('plugins.index');

Route::post('/files', [FilesController::class, 'store'])->name('files.store');
Route::get('/files/{file}', [FilesController::class, 'download'])->name('files.download');

Route::put('/folders/reorder', [OrderController::class, 'folders'])->name('folders.reorder');
Route::put('/contents/reorder', [OrderController::class, 'folders'])->name('contents.reorder');
Route::put('/menu-items/reorder', [OrderController::class, 'menuItems'])->name('menu-items.reorder');

Route::get('/activities/paginated', [ActivitiesController::class, 'paginated'])->name('activities.paginated');
Route::get('/beacons/paginated', [BeaconsController::class, 'paginated'])->name('beacons.paginated');
Route::get('/beacon-providers/paginated', [BeaconProvidersController::class, 'paginated'])->name('beacon-providers.paginated');
Route::get('/buildings/paginated', [BuildingsController::class, 'paginated'])->name('buildings.paginated');
Route::get('/categories/paginated', [CategoriesController::class, 'paginated'])->name('categories.paginated');
Route::get('/components/paginated', [ComponentsController::class, 'paginated'])->name('components.paginated');
Route::get('/containers/paginated', [ContainersController::class, 'paginated'])->name('containers.paginated');
Route::get('/contents/paginated', [ContentsController::class, 'paginated'])->name('contents.paginated');
Route::get('/fixtures/paginated', [FixturesController::class, 'paginated'])->name('fixtures.paginated');
Route::get('/floors/paginated', [FloorsController::class, 'paginated'])->name('floors.paginated');
Route::get('/folders/paginated', [FoldersController::class, 'paginated'])->name('folders.paginated');
Route::get('/hits/paginated', [HitsController::class, 'paginated'])->name('hits.paginated');
Route::get('/imports/paginated', [ImportsController::class, 'paginated'])->name('imports.paginated');
Route::get('/menus/paginated', [MenusController::class, 'paginated'])->name('menus.paginated');
Route::get('/menu-items/paginated', [MenuItemsController::class, 'paginated'])->name('menu-items.paginated');
Route::get('/layouts/paginated', [LayoutsController::class, 'paginated'])->name('layouts.paginated');
Route::get('/locations/paginated', [LocationsController::class, 'paginated'])->name('locations.paginated');
Route::get('/places/paginated', [PlacesController::class, 'paginated'])->name('places.paginated');
Route::get('/pois/paginated', [PoisController::class, 'paginated'])->name('pois.paginated');
Route::get('/tokens/paginated', [TokensController::class, 'paginated'])->name('tokens.paginated');
Route::get('/users/paginated', [UsersController::class, 'paginated'])->name('users.paginated');
Route::get('/roles/paginated', [RolesController::class, 'paginated'])->name('roles.paginated');
Route::get('/tags/paginated', [TagsController::class, 'paginated'])->name('tags.paginated');
Route::get('/templates/paginated', [TemplatesController::class, 'paginated'])->name('templates.paginated');
Route::get('/skins/paginated', [SkinsController::class, 'paginated'])->name('skins.paginated');
Route::get('/structures/paginated', [StructuresController::class, 'paginated'])->name('structures.paginated');

Route::post('/beacons/import', [BeaconsController::class, 'import'])->name('beacons.import');

Route::delete('/containers/{container}/relationships/locations', [ContainerLocationsController::class, 'destroy'])->name('containers.locations.destroy');

Route::apiResource('activities', ActivitiesController::class)->only(['index', 'show']);
Route::apiResource('beacons', BeaconsController::class);
Route::apiResource('beacon-providers', BeaconProvidersController::class)->parameters(['beacon-providers' => 'provider']);
Route::apiResource('buildings', BuildingsController::class);
Route::apiResource('categories', CategoriesController::class);
Route::apiResource('components', ComponentsController::class);
Route::apiResource('containers', ContainersController::class);
Route::apiResource('contents', ContentsController::class);
Route::apiResource('fixtures', FixturesController::class);
Route::apiResource('floors', FloorsController::class);
Route::apiResource('folders', FoldersController::class);
Route::apiResource('hits', HitsController::class)->except(['update']);
Route::apiResource('imports', ImportsController::class)->only(['index', 'show']);
Route::apiResource('menus', MenusController::class);
Route::apiResource('menu-items', MenuItemsController::class);
Route::apiResource('layouts', LayoutsController::class);
Route::apiResource('locations', LocationsController::class);
Route::apiResource('permissions', PermissionsController::class);
Route::apiResource('places', PlacesController::class);
Route::apiResource('pois', PoisController::class)->parameters(['pois' => 'poi']);
Route::apiResource('tokens', TokensController::class);
Route::apiResource('users', UsersController::class);
Route::apiResource('roles', RolesController::class);
Route::apiResource('searchables', SearchController::class);
Route::apiResource('skins', SkinsController::class);
Route::apiResource('structures', StructuresController::class);
Route::apiResource('tags', TagsController::class);
Route::apiResource('templates', TemplatesController::class);

Route::post('/beacons/bulk-destroy', [BeaconsController::class, 'bulkDestroy'])->name('beacons.bulk-destroy');
Route::post('/beacon-providers/bulk-destroy', [BeaconProvidersController::class, 'bulkDestroy'])->name('beacon-providers.bulk-destroy');
Route::post('/buildings/bulk-destroy', [BuildingsController::class, 'bulkDestroy'])->name('buildings.bulk-destroy');
Route::post('/categories/bulk-destroy', [CategoriesController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
Route::post('/components/bulk-destroy', [ComponentsController::class, 'bulkDestroy'])->name('components.bulk-destroy');
Route::post('/containers/bulk-destroy', [ContainersController::class, 'bulkDestroy'])->name('containers.bulk-destroy');
Route::post('/contents/bulk-destroy', [ContentsController::class, 'bulkDestroy'])->name('contents.bulk-destroy');
Route::post('/fixtures/bulk-destroy', [FixturesController::class, 'bulkDestroy'])->name('fixtures.bulk-destroy');
Route::post('/floors/bulk-destroy', [FloorsController::class, 'bulkDestroy'])->name('floors.bulk-destroy');
Route::post('/folders/bulk-destroy', [FoldersController::class, 'bulkDestroy'])->name('folders.bulk-destroy');
Route::post('/hits/bulk-destroy', [HitsController::class, 'bulkDestroy'])->name('hits.bulk-destroy');
Route::post('/menus/bulk-destroy', [MenusController::class, 'bulkDestroy'])->name('menus.bulk-destroy');
Route::post('/menu-items/bulk-destroy', [MenuItemsController::class, 'bulkDestroy'])->name('menu-items.bulk-destroy');
Route::post('/layouts/bulk-destroy', [LayoutsController::class, 'bulkDestroy'])->name('layouts.bulk-destroy');
Route::post('/locations/bulk-destroy', [LocationsController::class, 'bulkDestroy'])->name('locations.bulk-destroy');
Route::post('/places/bulk-destroy', [PlacesController::class, 'bulkDestroy'])->name('places.bulk-destroy');
Route::post('/pois/bulk-destroy', [PoisController::class, 'bulkDestroy'])->name('pois.bulk-destroy');
Route::post('/tokens/bulk-destroy', [TokensController::class, 'bulkDestroy'])->name('tokens.bulk-destroy');
Route::post('/users/bulk-destroy', [UsersController::class, 'bulkDestroy'])->name('users.bulk-destroy');
Route::post('/roles/bulk-destroy', [RolesController::class, 'bulkDestroy'])->name('roles.bulk-destroy');
Route::post('/tags/bulk-destroy', [TagsController::class, 'bulkDestroy'])->name('tags.bulk-destroy');
Route::post('/templates/bulk-destroy', [TemplatesController::class, 'bulkDestroy'])->name('templates.bulk-destroy');
Route::post('/skins/bulk-destroy', [SkinsController::class, 'bulkDestroy'])->name('skins.bulk-destroy');
Route::post('/structures/bulk-destroy', [StructuresController::class, 'bulkDestroy'])->name('structures.bulk-destroy');

Route::group(['prefix' => 'beacons/{beacon}/containers/{container}'], function () {
    Route::get('/', [BeaconContainersController::class, 'show'])->name('beacon.containers.show');
    Route::post('/', [BeaconContainersController::class, 'store'])->name('beacon.containers.store');
    Route::put('/', [BeaconContainersController::class, 'update'])->name('beacon.containers.update');
    Route::delete('/', [BeaconContainersController::class, 'destroy'])->name('beacon.containers.destroy');
});

Route::group(['prefix' => 'containers/{container}/beacons'], function () {

    Route::post('/', [ContainerBeaconsController::class, 'store'])->name('container.beacons.store');

    Route::group(['prefix' => '{beacon}'], function () {
        Route::get('/', [ContainerBeaconsController::class, 'show'])->name('container.beacons.show');
        Route::post('/', [ContainerBeaconsController::class, 'store'])->name('container.beacons.store');
        Route::put('/', [ContainerBeaconsController::class, 'update'])->name('container.beacons.update');
        Route::delete('/', [ContainerBeaconsController::class, 'destroy'])->name('container.beacons.destroy');

        Route::post('/rules', [RulesController::class, 'store'])->name('rules.store');
        Route::get('/rules/{rule}', [RulesController::class, 'show'])->name('rules.show');
        Route::put('/rules/{rule}', [RulesController::class, 'update'])->name('rules.update');
        Route::delete('/rules/{rule}', [RulesController::class, 'destroy'])->name('rules.destroy');
    });
});
