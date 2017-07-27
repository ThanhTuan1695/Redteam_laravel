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

Route::group(['prefix' => 'public'],function(){
	Route::get('/', 'Frontend\HomeChatController@index');
	Route::post('registerUser', 'Frontend\RegisterController@store')->name('register_user');
	Route::get('loginChat', 'Frontend\LoginChatController@index')->name('loginChat');
	Route::post('submitLogin', 'Frontend\LoginChatController@login')->name('submitLogin');
	Route::get('homeChat', 'Frontend\ManagerController@index')->name('homeChat');
	Route::get('logoutPublic', 'Frontend\ManagerController@logoutPublic')->name('logoutPublic');

	Route::get('chooseUser/{id}', 'Frontend\ManagerController@chooseUser')->name('chooseUser');
	Route::get('addUser/{id}', 'Frontend\ManagerController@addUser')->name('addUser');
	Route::get('profileUser', 'Frontend\ManagerController@profileUser')->name('profileUser');
	Route::post('updateProfile/{id}', 'Frontend\ManagerController@updateProfile')->name('updateProfile');

	Route::get('single/{id}', 'Frontend\SingleController@index')->name('chatUser');
	Route::get('room/{id}', 'Frontend\RoomController@index')->name('chatRoom')
	->middleware('user_room');
	Route::get('callback/{id}', 'Frontend\RoomController@callback')->name('callback');
	Route::post('sendmessageuser', 'Frontend\SingleController@sendMessage')->name('addchat');
	Route::get('/sendmessage', 'Frontend\RoomController@sendMessage');
});

