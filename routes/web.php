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

Route::group([],function(){
	Route::get('register', 'Frontend\RegisterController@index')->name('register_public');
	Route::post('registerUser', 'Frontend\RegisterController@store')->name('register_user');
	Route::get('loginChat', 'Frontend\LoginChatController@index')->name('loginChat');
	Route::post('public/submitLogin', 'Frontend\LoginChatController@login')->name('submitLogin');	
	Route::group(['middleware'=>'before_login'],function(){
		Route::get('/','Frontend\HomeChatController@index');//xem xet lai
		Route::get('homeChat', 'Frontend\ManagerController@index')->name('homeChat');
		Route::get('chooseUser/{id}', 'Frontend\ManagerController@chooseUser')->name('chooseUser');
		Route::get('addUser/{id}', 'Frontend\ManagerController@addUser')->name('addUser');
		Route::get('profileUser', 'Frontend\ManagerController@profileUser')->name('profileUser');
		Route::post('public/updateProfile/{id}', 'Frontend\ManagerController@updateProfile')->name('updateProfile');
		Route::get('logoutPublic', 'Frontend\ManagerController@logoutPublic')->name('logoutPublic');
		Route::get('single/{id}', 'Frontend\SingleController@index')->name('chatUser');
		
		Route::get('room/{id}', 'Frontend\RoomController@index')->name('chatRoom')->middleware('user_room');
		Route::get('callback/{id}', 'Frontend\RoomController@callback')->name('callback');
		Route::get('outRoom/{id}', 'Frontend\RoomController@outRoom')->name('outRoom');
		Route::get('selectAdmin/{id}', 'Frontend\RoomController@selectAdmin')->name('selectAdmin');
		Route::get('changeAdmin/{id}', 'Frontend\RoomController@changeAdmin')->name('changeAdmin');
		Route::get('viewDetail/{id}', 'Frontend\RoomController@viewDetail')->name('viewDetail');

		Route::post('/public/sendmessageuser', 'Frontend\SingleController@sendMessage')->name('addchat');
		Route::post('/public/sendmessage', 'Frontend\RoomController@sendMessage');
	});
});

