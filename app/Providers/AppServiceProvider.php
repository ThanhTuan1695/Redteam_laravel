<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function($view) use ($auth) {
            $currentUser = $auth->user();
            if(!empty($currentUser)){
                if($currentUser->role == '2'){
                    $user_id = $currentUser->id;
                    $room_id = DB::table('user_room')->select('room_id')->where('user_id', $user_id)->get();
                    $arr = array_pluck($room_id, 'room_id');

                    $listRoomPL = DB::table('rooms')->whereIn('id', $arr)->orWhere('type', 'public')->get();
                } else {
                    $listRoomPL = DB::table('rooms')->get();
                }
                $listUserPL = DB::table('users')->orderBy('username', 'asc')->get();
                $view->with('listRoomPL', $listRoomPL);
                $view->with('listUserPL', $listUserPL);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
