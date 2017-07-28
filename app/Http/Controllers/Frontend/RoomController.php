<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\MessagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rooms;
use App\Models\User;
use Auth;
use DB;
use App\Models\Messages;
use LRedis;

class RoomController extends Controller
{
    private $messagesRepository;


    public function __construct( MessagesRepository $mesRepo)
    {
        $this->messagesRepository = $mesRepo;
    }

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
        $url = url('public/sendmessage');
        $receiver_id = $id;
        $medias = $get_room->medias()->get(['url','type'])->unique('url');
        return view('frontend.room.chatRoom', compact('messages', 'id', 'get_room', 'type','url','medias','receiver_id'));


    }

    public function sendMessage(Request $request)
    {
        $room = \App\Models\Rooms::find($request['id']);
        $this->messagesRepository->insertChat($request, $room);
        $data = $this->messagesRepository->sendMessage($request, 'room');
        return $data;
    }


}
