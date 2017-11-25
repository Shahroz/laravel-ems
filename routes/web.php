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
    	$router->resource('department', 'DepartmentController');
		$router->post('department/search', 'DepartmentController@search')
			->name('department.search');
		
		// Division routes	
		$router->resource('/division', 'DivisionController');
		$router->post('/division/search', 'DivisionController@search')
			->name('division.search');

		// Country routes
		$router->resource('/country', 'CountryController');
		$router->post('/country/search', 'CountryController@search')
			->name('country.search');

		// State routes
		$router->resource('/state', 'StateController');
		$router->post('/state/search', 'StateController@search')
			->name('state.search');

		// City routes
		$router->resource('/city', 'CityController');
		$router->post('/city/search', 'CityController@search')
			->name('city.search');

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
