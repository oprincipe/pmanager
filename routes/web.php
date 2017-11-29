<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Routes to all controllers
 */
Route::middleware(['auth'])->group(function() {
	Route::resource('companies', 'CompaniesController');
	Route::resource('companiescredits', 'CompaniesCreditsController');
	Route::resource('comments', 'CommentsController');
	Route::resource('projects', 'ProjectsController');
	Route::resource('roles', 'RolesController');
	Route::resource('tasks', 'TasksController');
	Route::resource('users', 'UsersController');

	Route::get('projects/create/{id?}', 'ProjectsController@create');
	Route::get('tasks/create/{project_id}', 'TasksController@create');
	Route::post('tasks/{id}/send', 'TasksEmailController@send');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
