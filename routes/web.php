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
    return redirect()->route('applications.index');
    // return redirect()->route('login');
});

Route::get('/home', function() {
	return redirect()->route('applications.index');
	// return redirect()->route('login');
});

Route::get('not-permitted', function(){
	return view('errors.not-permitted');
})->name('not-permitted');

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
			->defaults('roles', array('Admin', 'Principal'))
			->name('dashboard')
			->defaults('href', 'dashboard');

		// USER ROUTES
		Route::get('users', 'UsersController@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-users')
			->defaults('name', 'Users Management')
			->defaults('roles', array('Admin'))
			->name('users.index')
			->defaults('href', 'users');

		Route::get('users/get/{user}', 'UsersController@get')->name('users.get');

		Route::get('users/create', 'UsersController@create')->name('users.create');
		Route::post('users/store', 'UsersController@store')->name('users.store');

		Route::get('users/edit/{user}', 'UsersController@edit')->name('users.edit');
		Route::post('users/update', 'UsersController@update')->name('users.update');

		Route::get('users/delete/{user}', 'UsersController@delete')->name('users.delete');

		// APPLICANT ROUTES
		$name = "applications";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-file-text')
			->defaults('name', 'Applications')
			->defaults('roles', array('Admin', 'Encoder'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/get/{user}', ucfirst($name) . 'Controller@get')->name($name . '.get');

		Route::get($name . '/export/all', ucfirst($name) . 'Controller@exportAll')->name($name . '.export.all');
		Route::get($name . '/export/{applicant}/{type}', ucfirst($name) . 'Controller@exportApplication')->name($name . '.export.applicant');
		Route::get($name . '/exportLineUp/{applicant}/{type}', ucfirst($name) . 'Controller@exportLineUpApplication')->name($name . '.export.applicant');
		
		Route::get($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');

		Route::get($name . '/delete/{user}', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
		Route::get($name . '/lineUp', ucfirst($name) . 'Controller@lineUp')->name($name . '.lineUp');

		// Vessels ROUTES
		$name = "vessels";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-ship')
			->defaults('name', 'Vessels')
			->defaults('roles', array('Admin'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/get/{id?}', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::get("$name/getAll", ucfirst($name) . 'Controller@getAll')->name("$name.getAll");
		
		Route::get($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');

		Route::get($name . '/delete/{user}', ucfirst($name) . 'Controller@delete')->name($name . '.delete');

		// Line Up ROUTES
		$name = "lineUp";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-arrow-up')
			->defaults('name', 'Line-Up')
			->defaults('roles', array('Principal'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/get/{user}', ucfirst($name) . 'Controller@get')->name($name . '.get');
		
		Route::get($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');

		Route::get($name . '/delete/{user}', ucfirst($name) . 'Controller@delete')->name($name . '.delete');

		// DATATABLE ROUTES
		Route::post('datatables/applications', 'DatatablesController@applications')->name('datatables.applications');
		Route::post('datatables/users', 'DatatablesController@users')->name('datatables.users');
		Route::post('datatables/processedApplicant', 'DatatablesController@processedApplicant')->name('datatables.processedApplicant');
		Route::post('datatables/vessels', 'DatatablesController@vessels')->name('datatables.vessels');
	}
);