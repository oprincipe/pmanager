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
	Route::resource('files', 'FilesController');
	Route::resource('projects', 'ProjectsController');
	Route::resource('customerproject', 'CustomerProjectController');
	Route::resource('roles', 'RolesController');
	Route::resource('tasks', 'TasksController');
	Route::resource('users', 'UsersController');
	Route::resource('reports', 'ReportsController');
	Route::resource('customers', 'CustomersController');


	Route::get('projects/create/{id?}', 'ProjectsController@create');

	Route::get('tasks/create/{project_id}', 'TasksController@create');
	//Route::post('tasks/{id}/send', 'TasksEmailController@send');

	Route::get('customerproject/{customer_id}/{project_id}/unlink', 'CustomerProjectController@unlink')->name("customerproject.unlink");

	//Route::get('reports/company/(id}/info', 'ReportsController@company_info');
	Route::get('reports/company/{company_id}', 'ReportsController@company_info');
	Route::get('reports/project/{project_id}', 'ReportsController@project_info');

});


Auth::routes();

//Customers login
Route::prefix("customer")->group(function() {
	Route::get("/login", "Auth\CustomerLoginController@showLoginForm")->name("customer.login");
	Route::post("/login", "Auth\CustomerLoginController@login")->name("customer.login.submit");
});

Route::prefix("customersarea")->group(function() {
	Route::get("/dash", "CustomersArea\HomeController@index")->name("customersarea.dash");
	Route::get("/task/{task_id}", "CustomersArea\TasksController@show")->name("customersarea.task");
	Route::get("/file/{file_id}", "CustomersArea\FilesController@show")->name("customersarea.download");
});


Route::get('/home', 'HomeController@index')->name('home');
