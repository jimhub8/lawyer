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
    Route::resource('clients', 'ClientController');
    Route::resource('firms', 'FirmController');
    Route::resource('cases', 'CasesController');
    Route::resource('status', 'StatusController');
    Route::resource('practice', 'PracticeController');

    Route::get('/logoutOther', 'UserController@logoutOther')->name('logoutOther');
    Route::post('/logOtherDevices', 'UserController@logOtherDevices')->name('logOtherDevices');

});
