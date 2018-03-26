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


Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

Route::group(['middleware' => 'auth:api'], function(){

    /**
     * User details
     */
    Route::post('details', 'API\PassportController@getDetails');

    /**
     * Projects
     */
    Route::post('projectsList', 'API\ProjectsController@index');

});

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/