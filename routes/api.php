<?php

use Illuminate\Http\Request;

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

Route::group(['namespace' => 'API'], function () {

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

        Route::post('/login', 'AuthController@login');

        Route::post('/register', 'AuthController@register');

        Route::middleware(['auth:api'])->group(function () {

            Route::get('/details', 'AuthController@details');

            Route::get('/logout', 'AuthController@logout');
        });
    });

    Route::group(['prefix' => 'users', 'middleware' => ['auth:api']], function () {
        /* Users Management */
        Route::get('/', 'UsersController@list');

        Route::get('/{id}', 'UsersController@get');

        Route::post('/', 'UsersController@create');

        Route::put('/{id}', 'UsersController@update');

        Route::delete('/{id}', 'UsersController@delete');
    });
});

