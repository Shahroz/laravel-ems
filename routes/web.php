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

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/profile', 'ProfileController@index');

Route::group(
	['prefix' => 'user-management', 'as' => 'users.',
	'middleware' => 'auth'], function ($router) {
	    $router->post('/search', 'UserManagementController@search')
			->name('search');
		$router->resource('/', 'UserManagementController');	
});

Route::group(
	['prefix' => 'employee-management', 'as' => 'employee.',
    'middleware' => 'auth'], function ($router) {
    	$router->post('/search', 'EmployeeManagementController@search')
			->name('search');
    	$router->resource('/', 'EmployeeManagementController');
});

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