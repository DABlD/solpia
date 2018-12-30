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

/*
|--------------------------------------------------------------------------
| Tips in route grouping
|--------------------------------------------------------------------------
| 
| namespace = Inside Controllers/{namespace}
| prefix = All Url inside group prefixes with {prefix}/{url}
| as = All Route name inside group prefixes with {as}.{name}
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function() {
	return view('welcome');
});

Auth::routes();

// PUBLIC ROUTES
Route::get('validate', 'ValidationController@index');

//Authenticated
Route::group([
		'middleware' => 'auth',
	], function() {

		Route::get('dashboard', 'DashboardController@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-user')
			->defaults('name', 'Dashboard')
			->defaults('roles', array('Admin', 'Owner', 'Inventory Clerk', 'Sales Clerk'))
			->name('dashboard')
			->defaults('href', 'dashboard');

		// USER ROUTES
		Route::get('users', 'UsersController@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-users')
			->defaults('name', 'Users Management')
			->defaults('roles', array('Admin', 'Owner'))
			->name('users.index')
			->defaults('href', 'users');
		Route::get('users/get/{user}', 'UsersController@get')->name('users.get');

		// DATATABLE ROUTES
		Route::get('datatables/users', 'DatatablesController@users')->name('datatables.users');
	}
);