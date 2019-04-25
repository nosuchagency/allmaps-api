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
    Route::get('/containers/paginated', ['as' => 'containers.paginated', 'uses' => 'ContainersController@paginated']);
    Route::get('/fixtures/paginated', ['as' => 'fixtures.paginated', 'uses' => 'FixturesController@paginated']);
    Route::get('/floors/paginated', ['as' => 'floors.paginated', 'uses' => 'FloorsController@paginated']);
    Route::get('/components/paginated', ['as' => 'components.paginated', 'uses' => 'ComponentsController@paginated']);
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
    Route::apiResource('fixtures', 'FixturesController');
    Route::apiResource('floors', 'FloorsController');
    Route::apiResource('components', 'ComponentsController');
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
    Route::post('/fixtures/bulk-destroy', ['as' => 'fixtures.bulk-destroy', 'uses' => 'FixturesController@bulkDestroy']);
    Route::post('/floors/bulk-destroy', ['as' => 'floors.bulk-destroy', 'uses' => 'FloorsController@bulkDestroy']);
    Route::post('/components/bulk-destroy', ['as' => 'components.bulk-destroy', 'uses' => 'ComponentsController@bulkDestroy']);
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

    Route::group(['prefix' => 'containers'], function () {
        Route::get('/', ['as' => 'containers.index', 'uses' => 'ContainersController@index']);
        Route::post('/', ['as' => 'containers.store', 'uses' => 'ContainersController@store']);
        Route::post('/bulk-destroy', ['as' => 'containers.bulk-destroy', 'uses' => 'ContainersController@bulkDestroy']);

        Route::group(['prefix' => '{container}'], function () {
            Route::post('/beacons', ['as' => 'container.beacons.store', 'uses' => 'ContainerBeaconsController@store']);

            Route::get('/', ['as' => 'containers.show', 'uses' => 'ContainersController@show']);
            Route::put('/', ['as' => 'containers.update', 'uses' => 'ContainersController@update']);
            Route::delete('/', ['as' => 'containers.destroy', 'uses' => 'ContainersController@destroy']);

            Route::group(['prefix' => 'folders'], function () {
                Route::get('/', ['as' => 'folders.Index', 'uses' => 'FoldersController@index']);
                Route::post('/', ['as' => 'folders.store', 'uses' => 'FoldersController@store']);

                Route::group(['prefix' => '{folder}'], function () {
                    Route::get('/', ['as' => 'folders.show', 'uses' => 'FoldersController@show']);
                    Route::put('/', ['as' => 'folders.update', 'uses' => 'FoldersController@update']);
                    Route::delete('/', ['as' => 'folders.destroy', 'uses' => 'FoldersController@destroy']);

                    Route::group(['prefix' => 'images'], function () {
                        Route::post('/', ['as' => 'contents.images.store', 'uses' => 'ImageContentsController@store']);
                        Route::put('/{image}', ['as' => 'contents.images.update', 'uses' => 'ImageContentsController@update']);
                        Route::delete('/{image}', ['as' => 'contents.images.destroy', 'uses' => 'ImageContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'videos'], function () {
                        Route::post('/', ['as' => 'contents.videos.store', 'uses' => 'VideoContentsController@store']);
                        Route::put('/{video}', ['as' => 'contents.videos.update', 'uses' => 'VideoContentsController@update']);
                        Route::delete('/{video}', ['as' => 'contents.videos.destroy', 'uses' => 'VideoContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'files'], function () {
                        Route::post('/', ['as' => 'contents.files.store', 'uses' => 'FileContentsController@store']);
                        Route::put('/{file}', ['as' => 'contents.files.update', 'uses' => 'FileContentsController@update']);
                        Route::delete('/{file}', ['as' => 'contents.files.destroy', 'uses' => 'FileContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'galleries'], function () {
                        Route::post('/', ['as' => 'contents.galleries.store', 'uses' => 'GalleryContentsController@store']);
                        Route::put('/{gallery}', ['as' => 'contents.galleries.update', 'uses' => 'GalleryContentsController@update']);
                        Route::delete('/{gallery}', ['as' => 'contents.galleries.destroy', 'uses' => 'GalleryContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'texts'], function () {
                        Route::post('/', ['as' => 'contents.texts.store', 'uses' => 'TextContentsController@store']);
                        Route::put('/{text}', ['as' => 'contents.texts.update', 'uses' => 'TextContentsController@update']);
                        Route::delete('/{text}', ['as' => 'contents.texts.destroy', 'uses' => 'TextContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'web'], function () {
                        Route::post('/', ['as' => 'contents.web.store', 'uses' => 'WebContentsController@store']);
                        Route::put('/{web}', ['as' => 'contents.web.update', 'uses' => 'WebContentsController@update']);
                        Route::delete('/{web}', ['as' => 'contents.web.destroy', 'uses' => 'WebContentsController@destroy']);
                    });
                });
            });
        });
    });
});