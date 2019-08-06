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

Route::get('signup/activate/{token}', 'AuthController@signupActivate');

Auth::routes(['verify' => true]);

Route::get('users/{id}', function ($id) {

});
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', 'HomeController@courier')->name('courier');
    Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('clients', 'ClientController');
    Route::resource('firms', 'FirmController');
    Route::resource('cases', 'CasesController');
    Route::resource('status', 'StatusController');
    Route::resource('practice', 'PracticeController');
    Route::resource('tasks', 'TaskController');
    Route::resource('stage', 'StageController');
    Route::get('/events', 'EventController@events')->name('events');



    Route::get('/logoutOther', 'UserController@logoutOther')->name('logoutOther');
	Route::post('/logOtherDevices', 'UserController@logOtherDevices')->name('logOtherDevices');
	Route::post('permisions/{id}', 'UserController@permisions')->name('permisions');
	Route::get('getUsers', 'UserController@getUsers')->name('getUsers');
	Route::get('getDrivers', 'UserController@getDrivers')->name('getDrivers');
	Route::get('getCustomer', 'UserController@getCustomer')->name('getCustomer');
	Route::get('getLogedinUsers', 'UserController@getLogedinUsers')->name('getLogedinUsers');
	Route::post('profile/{id}', 'UserController@profile')->name('profile');
	Route::post('getSorted', 'UserController@getSorted')->name('getSorted');
	Route::post('getUserPro/{id}', 'UserController@getUserPro')->name('getUserPro');
	Route::post('getUserPerm/{id}', 'UserController@getUserPerm')->name('getUserPerm');
	Route::post('password', 'UserController@password')->name('password');
	Route::patch('AuthUserUp/{id}', 'UserController@AuthUserUp')->name('AuthUserUp');
	Route::post('UserShip', 'UserController@UserShip')->name('UserShip');
	Route::get('deletedUsers', 'UserController@deletedUsers')->name('deletedUsers');
	Route::patch('undeletedUser/{id}', 'UserController@undeletedUser')->name('undeletedUser');


	Route::get('getUsersRole', 'RoleController@getUsersRole')->name('getUsersRole');
	Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');
	Route::get('getPermissions', 'RoleController@getPermissions')->name('getPermissions');
	Route::post('getRolesPerm/{id}', 'RoleController@getRolesPerm')->name('getRolesPerm');
	Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');
    Route::post('/carbon', 'RoleController@carbon')->name('carbon');


	Route::post('/filterCases', 'CasesController@filterCases')->name('filterCases');

});
