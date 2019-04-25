<?php

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

Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);

Route::post('/password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::post('/password/reset', ['as' => '', 'uses' => 'Auth\ResetPasswordController@reset']);

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

    Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@show']);

    Route::get('/search', ['as' => 'search', 'uses' => 'SearchController']);
    Route::get('/plugins', ['as' => 'plugins.index', 'uses' => 'PluginsController']);

    Route::get('/beacons/paginated', ['as' => 'beacons.paginated', 'uses' => 'BeaconsController@paginated']);
    Route::get('/buildings/paginated', ['as' => 'buildings.paginated', 'uses' => 'BuildingsController@paginated']);
    Route::get('/categories/paginated', ['as' => 'categories.paginated', 'uses' => 'CategoriesController@paginated']);
    Route::get('/components/paginated', ['as' => 'components.paginated', 'uses' => 'ComponentsController@paginated']);
    Route::get('/containers/paginated', ['as' => 'containers.paginated', 'uses' => 'ContainersController@paginated']);
    Route::get('/contents/paginated', ['as' => 'contents.paginated', 'uses' => 'ContentsController@paginated']);
    Route::get('/fixtures/paginated', ['as' => 'fixtures.paginated', 'uses' => 'FixturesController@paginated']);
    Route::get('/floors/paginated', ['as' => 'floors.paginated', 'uses' => 'FloorsController@paginated']);
    Route::get('/folders/paginated', ['as' => 'folders.paginated', 'uses' => 'FoldersController@paginated']);
    Route::get('/layouts/paginated', ['as' => 'layouts.paginated', 'uses' => 'LayoutsController@paginated']);
    Route::get('/locations/paginated', ['as' => 'locations.paginated', 'uses' => 'LocationsController@paginated']);
    Route::get('/places/paginated', ['as' => 'places.paginated', 'uses' => 'PlacesController@paginated']);
    Route::get('/pois/paginated', ['as' => 'pois.paginated', 'uses' => 'PoisController@paginated']);
    Route::get('/tokens/paginated', ['as' => 'tokens.paginated', 'uses' => 'TokensController@paginated']);
    Route::get('/users/paginated', ['as' => 'users.paginated', 'uses' => 'UsersController@paginated']);
    Route::get('/roles/paginated', ['as' => 'roles.paginated', 'uses' => 'RolesController@paginated']);
    Route::get('/tags/paginated', ['as' => 'tags.paginated', 'uses' => 'TagsController@paginated']);
    Route::get('/templates/paginated', ['as' => 'templates.paginated', 'uses' => 'TemplatesController@paginated']);
    Route::get('/structures/paginated', ['as' => 'structures.paginated', 'uses' => 'StructuresController@paginated']);

    Route::apiResource('beacons', 'BeaconsController');
    Route::apiResource('buildings', 'BuildingsController');
    Route::apiResource('categories', 'CategoriesController');
    Route::apiResource('components', 'ComponentsController');
    Route::apiResource('containers', 'ContainersController');
    Route::apiResource('contents', 'ContentsController');
    Route::apiResource('fixtures', 'FixturesController');
    Route::apiResource('floors', 'FloorsController');
    Route::apiResource('folders', 'FoldersController');
    Route::apiResource('layouts', 'LayoutsController');
    Route::apiResource('locations', 'LocationsController');
    Route::apiResource('permissions', 'PermissionsController');
    Route::apiResource('places', 'PlacesController');
    Route::apiResource('pois', 'PoisController')->parameters(['pois' => 'poi']);
    Route::apiResource('tokens', 'TokensController');
    Route::apiResource('users', 'UsersController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('searchables', 'SearchablesController');
    Route::apiResource('structures', 'StructuresController');
    Route::apiResource('tags', 'TagsController');
    Route::apiResource('templates', 'TemplatesController');

    Route::post('/beacons/bulk-destroy', ['as' => 'beacons.bulk-destroy', 'uses' => 'BeaconsController@bulkDestroy']);
    Route::post('/buildings/bulk-destroy', ['as' => 'buildings.bulk-destroy', 'uses' => 'BuildingsController@bulkDestroy']);
    Route::post('/categories/bulk-destroy', ['as' => 'categories.bulk-destroy', 'uses' => 'CategoriesController@bulkDestroy']);
    Route::post('/components/bulk-destroy', ['as' => 'components.bulk-destroy', 'uses' => 'ComponentsController@bulkDestroy']);
    Route::post('/containers/bulk-destroy', ['as' => 'containers.bulk-destroy', 'uses' => 'ContainersController@bulkDestroy']);
    Route::post('/contents/bulk-destroy', ['as' => 'contents.bulk-destroy', 'uses' => 'ContentsController@bulkDestroy']);
    Route::post('/fixtures/bulk-destroy', ['as' => 'fixtures.bulk-destroy', 'uses' => 'FixturesController@bulkDestroy']);
    Route::post('/floors/bulk-destroy', ['as' => 'floors.bulk-destroy', 'uses' => 'FloorsController@bulkDestroy']);
    Route::post('/folders/bulk-destroy', ['as' => 'folders.bulk-destroy', 'uses' => 'FoldersController@bulkDestroy']);
    Route::post('/structures/bulk-destroy', ['as' => 'structures.bulk-destroy', 'uses' => 'StructuresController@bulkDestroy']);
    Route::post('/layouts/bulk-destroy', ['as' => 'layouts.bulk-destroy', 'uses' => 'LayoutsController@bulkDestroy']);
    Route::post('/locations/bulk-destroy', ['as' => 'locations.bulk-destroy', 'uses' => 'LocationsController@bulkDestroy']);
    Route::post('/places/bulk-destroy', ['as' => 'places.bulk-destroy', 'uses' => 'PlacesController@bulkDestroy']);
    Route::post('/pois/bulk-destroy', ['as' => 'pois.bulk-destroy', 'uses' => 'PoisController@bulkDestroy']);
    Route::post('/tokens/bulk-destroy', ['as' => 'tokens.bulk-destroy', 'uses' => 'TokensController@bulkDestroy']);
    Route::post('/users/bulk-destroy', ['as' => 'users.bulk-destroy', 'uses' => 'UsersController@bulkDestroy']);
    Route::post('/roles/bulk-destroy', ['as' => 'roles.bulk-destroy', 'uses' => 'RolesController@bulkDestroy']);
    Route::post('/tags/bulk-destroy', ['as' => 'tags.bulk-destroy', 'uses' => 'TagsController@bulkDestroy']);
    Route::post('/templates/bulk-destroy', ['as' => 'templates.bulk-destroy', 'uses' => 'TemplatesController@bulkDestroy']);

    Route::group(['prefix' => 'beacons/{beacon}/containers/{container}'], function () {
        Route::get('/', ['as' => 'beacon.containers.show', 'uses' => 'BeaconContainersController@show']);
        Route::post('/', ['as' => 'beacon.containers.store', 'uses' => 'BeaconContainersController@store']);
        Route::put('/', ['as' => 'beacon.containers.update', 'uses' => 'BeaconContainersController@update']);
        Route::delete('/', ['as' => 'beacon.containers.destroy', 'uses' => 'BeaconContainersController@destroy']);
    });

    Route::post('/containers/{container}/beacons', ['as' => 'container.beacons.store', 'uses' => 'ContainerBeaconsController@store']);

    Route::group(['prefix' => 'containers/{container}/beacons/{beacon}'], function () {
        Route::get('/', ['as' => 'container.beacons.show', 'uses' => 'ContainerBeaconsController@show']);
        Route::put('/', ['as' => 'container.beacons.update', 'uses' => 'ContainerBeaconsController@update']);
        Route::post('/', ['as' => 'container.beacons.store', 'uses' => 'ContainerBeaconsController@store']);
        Route::delete('/', ['as' => 'container.beacons.destroy', 'uses' => 'ContainerBeaconsController@destroy']);

        Route::post('/rules', ['as' => 'rules.store', 'uses' => 'RulesController@store']);
        Route::get('/rules/{rule}', ['as' => 'rules.show', 'uses' => 'RulesController@show']);
        Route::put('/rules/{rule}', ['as' => 'rules.update', 'uses' => 'RulesController@update']);
        Route::delete('/rules/{rule}', ['as' => 'rules.destroy', 'uses' => 'RulesController@destroy']);
    });

    Route::put('/folders/reorder', ['as' => 'folders.reorder', 'uses' => 'OrderController@folders']);
    Route::put('/contents/reorder', ['as' => 'contents.reorder', 'uses' => 'OrderController@contents']);
});