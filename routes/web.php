<?php

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Auth::routes();
Route::get('/profile', 'ProfileController@index')
	->middleware('auth');
Route::group([
		'prefix' => 'user-management', 
		'as' => 'user.',
		'middleware' => 'auth'
	], function ($router) {
	    $router->post('/search', 'UserManagementController@search')
			->name('search');
});
Route::resource('/user-management', 'UserManagementController', [
	'names' 	 => 'user', 
	'parameters' => [
		'user-management' => 'user'
	]
]);

Route::group(
	['prefix' => 'employee-management', 'as' => 'employee.',
    'middleware' => 'auth'], function ($router) {
    	$router->post('/search', 'EmployeeManagementController@search')
			->name('search');
});
Route::resource('/employee-management', 'EmployeeManagementController', [
	'names' 	 => 'employee', 
	'parameters' => [
		'employee-management' => 'employee'
	]
]);

Route::group(
    ['prefix' => 'system-management', 'as' => 'system.',
    'middleware' => 'auth'], function ($router) {
    	// Department routes
    	$router->resource('departments', 'DepartmentController');
		$router->post('departments/search', 'DepartmentController@search')
			->name('departments.search');
		
		// Division routes	
		$router->resource('/divisions', 'DivisionController');
		$router->post('/divisions/search', 'DivisionController@search')
			->name('divisions.search');

		// Country routes
		$router->resource('/countries', 'CountryController');
		$router->post('/countries/search', 'CountryController@search')
			->name('countries.search');

		// State routes
		$router->resource('/states', 'StateController');
		$router->post('/states/search', 'StateController@search')
			->name('states.search');

		// Report routes
		$router->get('/report', 'ReportController@index')
			->name('report.index');
		$router->post('/report/search', 'ReportController@search')
			->name('report.search');

		$router->post('/report/excel', 'ReportController@exportExcel')
			->name('report.excel');
		$router->post('/report/pdf', 'ReportController@exportPDF')
			->name('report.pdf');	
});

Route::get('avatars/{name}', 'EmployeeManagementController@load');
