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
Route::get('/', ['as' => 'home.index', 'uses' => 'Backend\HomeController@index']);

Route::group(['prefix' => 'admin','middleware'=>'admin'],function(){
	Route::resource('rooms', 'Backend\RoomsController');
	Route::resource('messages', 'Backend\MessagesController');
	Route::resource('media', 'Backend\MediaController');
	Route::resource('users', 'Backend\UserController');
});

Route::group(['prefix' => 'public'],function(){
	Route::get('/', 'Frontend\HomeChatController@index');
	Route::post('registerUser', 'Frontend\RegisterController@store')->name('register_user');
	Route::get('loginChat', 'Frontend\LoginChatController@index')->name('loginChat');
	Route::post('submitLogin', 'Frontend\LoginChatController@login')->name('submitLogin');
	Route::get('homeChat', 'Frontend\ManagerController@index')->name('homeChat');
});

