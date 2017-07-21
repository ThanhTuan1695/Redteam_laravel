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

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();
// Route::get('/home', 'HomeController@index');
// ?public
Route::get('/',function(){
	 echo "asdsa";
});

Route::get('/404',function(){
	 return view('errors.404');
});

Route::group(['prefix' => 'admin','middleware'=>'admin'],function(){
	Route::get('/', ['as' => 'home.index', 'uses' => 'Backend\HomeController@index']);
	Route::resource('rooms', 'Backend\RoomsController');
	Route::resource('messages', 'Backend\MessagesController');
	Route::resource('media', 'Backend\MediaController');
	Route::resource('users', 'Backend\UserController');
});