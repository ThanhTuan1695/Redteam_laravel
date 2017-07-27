<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Rooms;
use App\Models\Messages;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use LRedis;
use Reponse;

class RoomController extends Controller
{
    public function index($id)
    {
        $get_room = Rooms::find($id);
        $messages = $get_room->messages;
        $user_id = Auth::user()->id;
        $check = DB::table('user_room')->where('user_id', '=', $user_id)
            ->where('room_id', '=', $id)->get();
        $data = array('user_id' => $user_id, 'room_id' => $id);
        if ($check->isEmpty()) {
            DB::table('user_room')->insert($data);
        }

        return view('frontend.room.chatRoom', compact('messages', 'id', 'get_room'));
    }

    public function sendMessage(Request $request)
    {
        $content = e($request->input('message'));
        $data = new Messages(['content' => $content, 'user_id' => Auth::user()->id]);
        Rooms::find($request->input('room_id'))->messages()->save($data);
        $message2 = Messages::with('user')->orderBy('id', 'desc')->first();
        $redis = LRedis::connection();
        $redis->publish('message', $message2);
    }

    public function callback($id)
    {
        return $this->index($id);
    }
}
