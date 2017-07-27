<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Rooms;

class IsUserRoom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role ==1) {
            return $next($request);
        } else {
            $room = Rooms::where('id',$request->id)->first();
            if($room->type == 'private') {
                $user_id = DB::table('user_room')->select('user_id')->where('room_id', $request->id)->get();
                $arr = $user_id->toArray();
                $arr1 = array_pluck($arr, 'user_id');
                $current_userid = Auth::user()->id;
                if($arr1[0] == $current_userid) {
                    return $next($request);
                } else {
                    return redirect(route('homeChat'));
                }
            }else {
                return $next($request);
            }
        }
        
    }
}
