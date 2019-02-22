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
    Route::put('/profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

    Route::get('/beacons/paginated', ['as' => 'beacons.paginated', 'uses' => 'BeaconsController@paginated']);
    Route::get('/categories/paginated', ['as' => 'categories.paginated', 'uses' => 'CategoriesController@paginated']);
    Route::get('/containers/paginated', ['as' => 'containers.paginated', 'uses' => 'ContainersController@paginated']);
    Route::get('/findables/paginated', ['as' => 'findables.paginated', 'uses' => 'FindablesController@paginated']);
    Route::get('/map-components/paginated', ['as' => 'map-components.paginated', 'uses' => 'MapComponentsController@paginated']);
    Route::get('/layouts/paginated', ['as' => 'layouts.paginated', 'uses' => 'LayoutsController@paginated']);
    Route::get('/pois/paginated', ['as' => 'pois.paginated', 'uses' => 'PoisController@paginated']);
    Route::get('/tokens/paginated', ['as' => 'tokens.paginated', 'uses' => 'TokensController@paginated']);
    Route::get('/users/paginated', ['as' => 'users.paginated', 'uses' => 'UsersController@paginated']);
    Route::get('/roles/paginated', ['as' => 'roles.paginated', 'uses' => 'RolesController@paginated']);
    Route::get('/tags/paginated', ['as' => 'tags.paginated', 'uses' => 'TagsController@paginated']);
    Route::get('/templates/paginated', ['as' => 'templates.paginated', 'uses' => 'TemplatesController@paginated']);

    Route::apiResource('beacons', 'BeaconsController');
    Route::apiResource('categories', 'CategoriesController');
    Route::apiResource('findables', 'FindablesController');
    Route::apiResource('map-components', 'MapComponentsController');
    Route::apiResource('layouts', 'LayoutsController');
    Route::apiResource('pois', 'PoisController')->parameters(['pois' => 'poi']);
    Route::apiResource('tokens', 'TokensController');
    Route::apiResource('users', 'UsersController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('tags', 'TagsController');
    Route::apiResource('templates', 'TemplatesController');

    Route::post('/beacons/bulk-destroy', ['as' => 'beacons.bulk-destroy', 'uses' => 'BeaconsController@bulkDestroy']);
    Route::post('/categories/bulk-destroy', ['as' => 'categories.bulk-destroy', 'uses' => 'CategoriesController@bulkDestroy']);
    Route::post('/findables/bulk-destroy', ['as' => 'findable.bulk-destroy', 'uses' => 'FindablesController@bulkDestroy']);
    Route::post('/map-components/bulk-destroy', ['as' => 'map-components.bulk-destroy', 'uses' => 'MapComponentsController@bulkDestroy']);
    Route::post('/layouts/bulk-destroy', ['as' => 'layouts.bulk-destroy', 'uses' => 'LayoutsController@bulkDestroy']);
    Route::post('/pois/bulk-destroy', ['as' => 'pois.bulk-destroy', 'uses' => 'PoisController@bulkDestroy']);
    Route::post('/tokens/bulk-destroy', ['as' => 'tokens.bulk-destroy', 'uses' => 'TokensController@bulkDestroy']);
    Route::post('/users/bulk-destroy', ['as' => 'users.bulk-destroy', 'uses' => 'UsersController@bulkDestroy']);
    Route::post('/roles/bulk-destroy', ['as' => 'roles.bulk-destroy', 'uses' => 'RolesController@bulkDestroy']);
    Route::post('/tags/bulk-destroy', ['as' => 'tags.bulk-destroy', 'uses' => 'TagsController@bulkDestroy']);
    Route::post('/templates/bulk-destroy', ['as' => 'templates.bulk-destroy', 'uses' => 'TemplatesController@bulkDestroy']);

    Route::group(['prefix' => 'roles/{role}/permissions/{permission}'], function () {
        Route::post('/', ['as' => 'role.permission.grant', 'uses' => 'RolesController@grantPermission']);
        Route::delete('/', ['as' => 'role.permission.revoke', 'uses' => 'RolesController@revokePermission']);
    });

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

    Route::group(['prefix' => 'places'], function () {
        Route::post('/bulk-destroy', ['as' => 'place.bulk-destroy', 'uses' => 'PlacesController@bulkDestroy']);
        Route::get('/', ['as' => 'place.index', 'uses' => 'PlacesController@index']);
        Route::get('/paginated', ['as' => 'places.paginated', 'uses' => 'PlacesController@paginated']);
        Route::post('/', ['as' => 'place.store', 'uses' => 'PlacesController@store']);

        Route::group(['prefix' => '{place}'], function () {
            Route::get('/', ['as' => 'place.show', 'uses' => 'PlacesController@show']);
            Route::put('/', ['as' => 'place.update', 'uses' => 'PlacesController@update']);
            Route::delete('/', ['as' => 'place.destroy', 'uses' => 'PlacesController@destroy']);

            Route::group(['prefix' => 'buildings'], function () {
                Route::get('/', ['as' => 'building.index', 'uses' => 'BuildingsController@index']);
                Route::get('/', ['as' => 'building.paginated', 'uses' => 'BuildingsController@paginated']);
                Route::post('/', ['as' => 'building.store', 'uses' => 'BuildingsController@store']);

                Route::group(['prefix' => '{building}'], function () {
                    Route::get('/', ['as' => 'building.show', 'uses' => 'BuildingsController@show']);
                    Route::put('/', ['as' => 'building.update', 'uses' => 'BuildingsController@update']);
                    Route::delete('/', ['as' => 'building.destroy', 'uses' => 'BuildingsController@destroy']);

                    Route::group(['prefix' => 'floors'], function () {
                        Route::get('/', ['as' => 'floor.index', 'uses' => 'FloorsController@index']);
                        Route::get('/', ['as' => 'floor.paginated', 'uses' => 'FloorsController@paginated']);
                        Route::post('/', ['as' => 'floor.store', 'uses' => 'FloorsController@store']);

                        Route::group(['prefix' => '{floor}'], function () {
                            Route::get('/', ['as' => 'floor.show', 'uses' => 'FloorsController@show']);
                            Route::put('/', ['as' => 'floor.update', 'uses' => 'FloorsController@update']);
                            Route::delete('/', ['as' => 'floor.destroy', 'uses' => 'FloorsController@destroy']);

                            Route::group(['prefix' => 'structures'], function () {
                                Route::get('/', ['as' => 'structure.index', 'uses' => 'MapStructuresController@index']);
                                Route::get('/', ['as' => 'structure.paginated', 'uses' => 'MapStructuresController@paginated']);
                                Route::post('/', ['as' => 'structure.store', 'uses' => 'MapStructuresController@store']);

                                Route::group(['prefix' => '{structure}'], function () {
                                    Route::get('/', ['as' => 'structure.show', 'uses' => 'MapStructuresController@show']);
                                    Route::put('/', ['as' => 'structure.update', 'uses' => 'MapStructuresController@update']);
                                    Route::delete('/', ['as' => 'structure.destroy', 'uses' => 'MapStructuresController@destroy']);
                                });
                            });

                            Route::group(['prefix' => 'locations'], function () {
                                Route::get('/', ['as' => 'location.index', 'uses' => 'MapLocationsController@index']);
                                Route::post('/', ['as' => 'location.store', 'uses' => 'MapLocationsController@store']);
                                Route::put('/{location}', ['as' => 'location.update', 'uses' => 'MapLocationsController@update']);
                                Route::delete('/{location}', ['as' => 'location.destroy', 'uses' => 'MapLocationsController@delete']);
                            });
                        });
                    });
                });
            });
        });
    });

    Route::put('/folders/reorder', ['as' => 'folders.reorder', 'uses' => 'OrderController@folders']);
    Route::put('/contents/reorder', ['as' => 'contents.reorder', 'uses' => 'OrderController@contents']);

    Route::group(['prefix' => 'containers'], function () {
        Route::get('/', ['as' => 'content.index', 'uses' => 'ContainersController@index']);
        Route::post('/', ['as' => 'content.store', 'uses' => 'ContainersController@store']);
        Route::post('/bulk-destroy', ['as' => 'content.bulk-destroy', 'uses' => 'ContainersController@bulkDestroy']);

        Route::group(['prefix' => '{container}'], function () {
            Route::post('/beacons', ['as' => 'container.beacons.store', 'uses' => 'ContainerBeaconsController@store']);

            Route::get('/', ['as' => 'container.show', 'uses' => 'ContainersController@show']);
            Route::put('/', ['as' => 'container.update', 'uses' => 'ContainersController@update']);
            Route::delete('/', ['as' => 'container.destroy', 'uses' => 'ContainersController@destroy']);

            Route::group(['prefix' => 'folders'], function () {
                Route::get('/', ['as' => 'folder.Index', 'uses' => 'FoldersController@index']);
                Route::post('/', ['as' => 'folder.store', 'uses' => 'FoldersController@store']);

                Route::group(['prefix' => '{folder}'], function () {
                    Route::get('/', ['as' => 'folder.show', 'uses' => 'FoldersController@show']);
                    Route::put('/', ['as' => 'folder.update', 'uses' => 'FoldersController@update']);
                    Route::delete('/', ['as' => 'folder.destroy', 'uses' => 'FoldersController@destroy']);

                    Route::group(['prefix' => 'images'], function () {
                        Route::post('/', ['as' => 'content.images.store', 'uses' => 'ImageContentsController@store']);
                        Route::put('/{image}', ['as' => 'content.images.update', 'uses' => 'ImageContentsController@update']);
                        Route::delete('/{image}', ['as' => 'content.images.destroy', 'uses' => 'ImageContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'videos'], function () {
                        Route::post('/', ['as' => 'content.videos.store', 'uses' => 'VideoContentsController@store']);
                        Route::put('/{video}', ['as' => 'content.videos.update', 'uses' => 'VideoContentsController@update']);
                        Route::delete('/{video}', ['as' => 'content.videos.destroy', 'uses' => 'VideoContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'files'], function () {
                        Route::post('/', ['as' => 'content.files.store', 'uses' => 'FileContentsController@store']);
                        Route::put('/{file}', ['as' => 'content.files.update', 'uses' => 'FileContentsController@update']);
                        Route::delete('/{file}', ['as' => 'content.files.destroy', 'uses' => 'FileContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'galleries'], function () {
                        Route::post('/', ['as' => 'content.galleries.store', 'uses' => 'GalleryContentsController@store']);
                        Route::put('/{gallery}', ['as' => 'content.galleries.update', 'uses' => 'GalleryContentsController@update']);
                        Route::delete('/{gallery}', ['as' => 'content.galleries.destroy', 'uses' => 'GalleryContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'texts'], function () {
                        Route::post('/', ['as' => 'content.texts.store', 'uses' => 'TextContentsController@store']);
                        Route::put('/{text}', ['as' => 'content.texts.update', 'uses' => 'TextContentsController@update']);
                        Route::delete('/{text}', ['as' => 'content.texts.destroy', 'uses' => 'TextContentsController@destroy']);
                    });

                    Route::group(['prefix' => 'web'], function () {
                        Route::post('/', ['as' => 'content.web.store', 'uses' => 'WebContentsController@store']);
                        Route::put('/{web}', ['as' => 'content.web.update', 'uses' => 'WebContentsController@update']);
                        Route::delete('/{web}', ['as' => 'content.web.destroy', 'uses' => 'WebContentsController@destroy']);
                    });
                });
            });
        });
    });
});