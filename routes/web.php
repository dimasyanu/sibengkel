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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', 'MainController');
});

Route::group(['middleware' => 'admin'], function() {
	Route::get('admin', 'AdminController@index');
	// Route::get('admin/{menu}', 'AdminController@index');
	// Route::post('admin/{menu}', 'AdminController@index');
	// Route::get('admin/{menu}/{action}/{id}', 'AdminController@crud');
	// Route::post('admin/{menu}/{action}/{id}', 'AdminController@crud');

	Route::get('admin/category', 'CategoryController@index');
	Route::post('admin/category', 'CategoryController@index');
	Route::get('admin/category/{action}/{id}', 'CategoryController@crud');
	Route::post('admin/category/{action}/{id}', 'CategoryController@crud');

	Route::get('admin/bengkel', 'BengkelController@index');
	Route::post('admin/bengkel', 'BengkelController@index');
	Route::get('admin/bengkel/{action}/{id}', 'BengkelController@crud');
	Route::post('admin/bengkel/{action}/{id}', 'BengkelController@crud');
});