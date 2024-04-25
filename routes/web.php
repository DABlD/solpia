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
    // return redirect()->route('applications.index');
    return redirect()->route('dashboard');
});

Route::get('/home', function() {
	// return redirect()->route('applications.index');
	return redirect()->route('dashboard');
});

Route::get('not-permitted', function(){
	return view('errors.not-permitted');
})->name('not-permitted');

Route::group(['middleware' => 'cors'], function() {
	Route::get('getOpenings','OpeningController@getOpenings' );
});

Auth::routes();

// PUBLIC ROUTES
Route::get('validate', 'ValidationController@index')->name('validate');
Route::get('validate/update', 'ValidationController@update')->name('validate.update');

//Authenticated
Route::group([
		'middleware' => 'auth',
	], function() {

		Route::get('dashboard', 'DashboardController@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-columns')
			->defaults('name', 'Dashboard')
			->defaults('roles', array('Admin', 'Principal', 'Crewing Officer', "Crewing Manager"))
			->name('dashboard')
			->defaults('href', 'dashboard');

		Route::get('clean', 'DashboardController@clean');
		Route::get('getCrewWithExpiredDocs', 'DashboardController@getCrewWithExpiredDocs')->name('dashboard.getCrewWithExpiredDocs');
		Route::get('report1', 'DashboardController@report1')->name('dashboard.report1');

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

		Route::get('users/ajaxUpdate', 'UsersController@ajaxUpdate')->name('users.ajaxUpdate');
		Route::get('users/ajaxUpdate2', 'UsersController@ajaxUpdate2')->name('users.ajaxUpdate2');

		Route::get('users/delete/{user}', 'UsersController@delete')->name('users.delete');

		// PRINCIPAL ROUTES
		$name = "principal";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-black-tie')
			->defaults('name', 'Principals')
			->defaults('roles', array('Admin', 'Processing', 'Encoder', 'Cadet'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/get', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');
		Route::post($name . '/update', ucfirst($name) . 'Controller@update')->name($name . '.update');
		Route::post($name . '/delete', ucfirst($name) . 'Controller@delete')->name($name . '.delete');

		Route::get($name . '/getOnboardCrew', ucfirst($name) . 'Controller@getOnboardCrew')->name($name . '.getOnboardCrew');

		// APPLICANT ROUTES
		$name = "applications";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-file-text')
			->defaults('name', 'Crew Database')
			->defaults('roles', array('Admin', 'Encoder', 'Cadet', 'Crewing Manager', 'Crewing Officer', 'Training', 'Processing'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/awardees', ucfirst($name) . 'Controller@awardees')->name($name . '.awardees');
		Route::get($name . '/get/{user}', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::get($name . '/get2', ucfirst($name) . 'Controller@get2')->name($name . '.get2');
		Route::get($name . '/getAddDetails/{applicant}', ucfirst($name) . 'Controller@getAddDetails')->name($name . '.getAddDetails');

		Route::get($name . '/export/all', ucfirst($name) . 'Controller@exportAll')->name($name . '.export.all');
		Route::get($name . '/export/{applicant}/{type?}', ucfirst($name) . 'Controller@exportApplication')->name($name . '.export.applicant');
		Route::get($name . '/exportLineUp/{applicant}/{type}', ucfirst($name) . 'Controller@exportLineUpApplication')->name($name . '.export.applicant');
		
		Route::get($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
		Route::get($name . '/edit/{applicant}', ucfirst($name) . 'Controller@edit')->name($name . '.edit');
		Route::post($name . '/update/{id}', ucfirst($name) . 'Controller@update')->name($name . '.update');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');

		Route::get($name . '/delete/{user}', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
		Route::get($name . '/lineUp', ucfirst($name) . 'Controller@lineUp')->name($name . '.lineUp');

		Route::post($name . '/updateData', ucfirst($name) . 'Controller@updateData')->name($name . '.updateData');
		Route::post("$name/getVesselCrew", ucfirst($name) . 'Controller@getVesselCrew')->name("$name.getVesselCrew");
		Route::get("$name/exportOnOff/{id?}/{type?}", ucfirst($name) . 'Controller@exportOnOff')->name("$name.exportOnOff");
		Route::get("$name/exportDocument/{id?}/{type?}", ucfirst($name) . 'Controller@exportDocument')->name("$name.exportDocument");

		Route::get("$name/goToPrincipal/{applicant?}", ucfirst($name) . 'Controller@goToPrincipal')->name("$name.goToPrincipal");
		Route::get("$name/getAllInfo", ucfirst($name) . 'Controller@getAllInfo')->name("$name.getAllInfo");

		// DETAILS FOR CREATE/EDIT
		Route::get("$name/getIssuers", ucfirst($name) . 'Controller@getIssuers')->name("$name.getIssuers");
		Route::get("$name/getRegulations", ucfirst($name) . 'Controller@getRegulations')->name("$name.getRegulations");
		Route::get("$name/getRanks", ucfirst($name) . 'Controller@getRanks')->name("$name.getRanks");

		// ON BOARD, ETC.
		Route::post("$name/updateStatus/{id?}/{status?}/{vessel_id?}", ucfirst($name) . 'Controller@updateStatus')->name("$name.updateStatus");
		Route::get("$name/updateProApp", ucfirst($name) . 'Controller@updateProApp')->name("$name.updateProApp");
		Route::get("$name/updateContract", ucfirst($name) . 'Controller@updateContract')->name("$name.updateContract");
		Route::get("$name/extendContract", ucfirst($name) . 'Controller@extendContract')->name("$name.extendContract");

		// SELECTING RELIEVER
		Route::post("$name/updateLineUpContract", ucfirst($name) . 'Controller@updateLineUpContract')->name("$name.updateLineUpContract");

		// FILES
		Route::post("$name/getFiles", ucfirst($name) . 'Controller@getFiles')->name("$name.getFiles");
		Route::post("$name/uploadFiles", ucfirst($name) . 'Controller@uploadFiles')->name("$name.uploadFiles");
		Route::post("$name/deleteFile", ucfirst($name) . 'Controller@deleteFile')->name("$name.deleteFile");

		// RANK ROUTES
		$name = "rank";
		// Route::get($name, ucfirst($name) . 'Controller@index')
		// 	->defaults('sidebar', 1)
		// 	->defaults('icon', 'fa-user-plus')
		// 	->defaults('name', 'Applicants')
		// 	->defaults('roles', array('Admin', 'Recruitment Officer'))
		// 	->name($name . '.index')
		// 	->defaults('href', $name);

		Route::get($name . '/get', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');
		Route::post($name . '/update', ucfirst($name) . 'Controller@update')->name($name . '.update');
		Route::post($name . '/delete', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
		
		// Vessels ROUTES
		$name = "vessels";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-ship')
			->defaults('name', 'Vessels')
			->defaults('roles', array('Admin', 'Crewing Manager', 'Cadet', 'Encoder', 'Crewing Officer', "Processing", "Training"))
			// USER ID OF SPECIAL PERMISSION
			->defaults('sped', array(33, 34, 461, 462, 506, 5))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/get/{id?}', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::get($name . '/get2', ucfirst($name) . 'Controller@get2')->name($name . '.get2');
		Route::get("$name/getAll", ucfirst($name) . 'Controller@getAll')->name("$name.getAll");
		Route::post("$name/import", ucfirst($name) . 'Controller@import')->name("$name.import");
		Route::get("$name/export", ucfirst($name) . 'Controller@export')->name("$name.export");
		// Route::get("$name/export/{type?}", ucfirst($name) . 'Controller@export')->name("$name.export");
		Route::get("$name/update", ucfirst($name) . 'Controller@update')->name("$name.update");
		Route::get("$name/updateAll", ucfirst($name) . 'Controller@updateAll')->name("$name.updateAll");
		Route::get("$name/getParticular", ucfirst($name) . 'Controller@getParticular')->name("$name.getParticular");
		Route::post("$name/updateParticular", ucfirst($name) . 'Controller@updateParticular')->name("$name.updateParticular");
		Route::get($name . '/add', ucfirst($name) . 'Controller@add')->name($name . '.add');

		// Line Up ROUTES
		$name = "lineUp";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-file-text')
			->defaults('name', 'Crew Database')
			->defaults('roles', array('Principal'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/get/{user}', ucfirst($name) . 'Controller@get')->name($name . '.get');
		
		Route::get($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
		Route::get($name . '/remove', ucfirst($name) . 'Controller@remove')->name($name . '.remove');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');

		Route::get($name . '/delete/{user}', ucfirst($name) . 'Controller@delete')->name($name . '.delete');

		// RECRUITMENT
		$name = "prospect";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-user-plus')
			->defaults('name', 'Applicants')
			->defaults('roles', array('Admin', 'Recruitment Officer'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/get', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');
		Route::post($name . '/update', ucfirst($name) . 'Controller@update')->name($name . '.update');
		Route::post($name . '/delete', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
		Route::post($name . '/uploadFile', ucfirst($name) . 'Controller@uploadFile')->name($name . '.uploadFile');
		Route::get($name . '/report/{from?}/{to?}', ucfirst($name) . 'Controller@report')->name($name . '.report');
		Route::get($name . '/prospectReport/{from?}/{to?}', ucfirst($name) . 'Controller@prospectReport')->name($name . '.prospectReport');
		Route::get($name . '/deploymentReport/{year?}', ucfirst($name) . 'Controller@deploymentReport')->name($name . '.deploymentReport');

		Route::get($name . '/suggestCandidate', ucfirst($name) . 'Controller@suggestCandidate')->name($name . '.suggestCandidate');
		Route::post($name . '/import', ucfirst($name) . 'Controller@import')->name($name . '.import');

		// CANDIDATES
		$name = "candidate";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-users')
			->defaults('name', 'Candidates')
			->defaults('roles', array('Admin', 'Recruitment Officer', 'Crewing Manager', 'Crewing Officer'))
			->name($name . '.index')
			->defaults('href', $name);

		// OPENINGS ROUTES
		$name = "requirement";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-briefcase')
			->defaults('name', 'Requirements')
			->defaults('roles', array('Admin', 'Crewing Manager', 'Crewing Officer', 'Training', 'Recruitment Officer'))
			->name($name . '.index')
			->defaults('href', $name);
			
		Route::get($name . '/get', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');
		Route::post($name . '/update', ucfirst($name) . 'Controller@update')->name($name . '.update');
		Route::post($name . '/delete', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
		Route::get($name . '/statusUpdate', ucfirst($name) . 'Controller@statusUpdate')->name($name . '.statusUpdate');

		// CANDIDATE ROUTES
		$name = "candidate";
			
		Route::get($name . '/get', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::post($name . '/store', ucfirst($name) . 'Controller@store')->name($name . '.store');
		Route::post($name . '/update', ucfirst($name) . 'Controller@update')->name($name . '.update');

		// WAGE ROUTES
		$name = "wage";
		// Route::get($name, ucfirst($name) . 'Controller@index')
		// 	->defaults('sidebar', 1)
		// 	->defaults('icon', 'fa-dollar')
		// 	->defaults('name', 'Wages')
		// 	->defaults('roles', array('Admin', 'Processing'))
		// 	->name($name . '.index')
		// 	->defaults('href', $name);

		Route::get($name . '/get', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::get($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
		Route::post($name . '/delete', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
		Route::post($name . '/update', ucfirst($name) . 'Controller@update')->name($name . '.update');
		Route::get($name . '/getVessels', ucfirst($name) . 'Controller@getVessels')->name($name . '.getVessels');
		Route::post($name . '/duplicate', ucfirst($name) . 'Controller@duplicate')->name($name . '.duplicate');

		// EVALUATION ROUTES
		$name = "evaluation";

		Route::get($name . '/get', ucfirst($name) . 'Controller@get')->name($name . '.get');
		Route::post($name . '/create', ucfirst($name) . 'Controller@create')->name($name . '.create');
		Route::post($name . '/delete', ucfirst($name) . 'Controller@delete')->name($name . '.delete');
		Route::post($name . '/update', ucfirst($name) . 'Controller@update')->name($name . '.update');

		// AUDIT TRAIL ROUTES
		$name = "auditTrail";
		Route::get($name, ucfirst($name) . 'Controller@index')
			->defaults('sidebar', 1)
			->defaults('icon', 'fa-history')
			->defaults('name', 'Audit Trail')
			->defaults('roles', array('Admin'))
			->name($name . '.index')
			->defaults('href', $name);

		Route::get($name . '/export', ucfirst($name) . 'Controller@export')->name($name . '.export');

		// DATATABLE ROUTES
		Route::post('1/recruitments', 'DatatablesController@recruitments')->name('datatables.recruitments');
		Route::post('datatables/applications', 'DatatablesController@applications')->name('datatables.applications');
		Route::get('datatables/applications2', 'DatatablesController@applications2');
		
		Route::post('datatables/users', 'DatatablesController@users')->name('datatables.users');
		Route::post('datatables/processedApplicant/{id}', 'DatatablesController@processedApplicant')->name('datatables.processedApplicant');
		Route::post('datatables/vessels', 'DatatablesController@vessels')->name('datatables.vessels');
		Route::post('datatables/openings', 'DatatablesController@openings')->name('datatables.openings');
		Route::post('datatables/auditTrail', 'DatatablesController@auditTrail')->name('datatables.auditTrail');
		Route::post('datatables/wages', 'DatatablesController@wages')->name('datatables.wages');
		Route::post('datatables/principals', 'DatatablesController@principals')->name('datatables.principals');


		Route::post('datatables/prospects', 'DatatablesController@prospects')->name('datatables.prospects');
		Route::post('datatables/requirements', 'DatatablesController@requirements')->name('datatables.requirements');
		Route::post('datatables/suggestCandidate', 'DatatablesController@suggestCandidate')->name('datatables.suggestCandidate');
		Route::post('datatables/candidates', 'DatatablesController@candidates')->name('datatables.candidates');

		// MISC
		Route::get('forceLogout', 'Auth\LoginController@forceLogout')->name('forceLogout');
		Route::get('generateApplicantFleet', 'ApplicationsController@generateApplicantFleet')->name('generateApplicantFleet');
		Route::get('generateSeaServiceSizeAndOwner', 'ApplicationsController@generateSeaServiceSizeAndOwner')->name('generateSeaServiceSizeAndOwner');
		Route::get('testFunc', 'ApplicationsController@testFunc')->name('testFunc');
		Route::get('testFunc2', 'ApplicationsController@testFunc2')->name('testFunc2');
		Route::get('tempFunc', 'ApplicationsController@tempFunc')->name('tempFunc');
		
	}
);