<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rooms;
use Auth;
use DB;
use App\Models\Messages;
use LRedis;

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
        $type = 'room';
        return view('frontend.room.chatRoom', compact('messages', 'id', 'get_room','type'));
    }
    public function sendMessage(Request $request)
    {
        $content = e($request->input('message'));
        $data = new Messages(['content' => $content, 'user_id' => Auth::user()->id]);
        Rooms::find($request->input('id'))->messages()->save($data);
        $message = Messages::with('user')->orderBy('id', 'desc')->first();
        if(file_exists( public_path() .'/backend/images/upload/'.$message->user->avatar) ){
            $avatar = $message->user->avatar;
        }
        else {
            $avatar = null;
        }
        $data = [
            'content' => \App\Helpers\Emojis::Smilify($content),
            'avatar' => $avatar,
            'created_at' => $message->created_at,
            'username' => $message->user->username,
            'messagesType' => 'room',
            'idChannel' => $request->input('id'),
        ];

        LRedis::publish('message', json_encode($data));

    }
}
