<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\MessagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rooms;
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
        return view('frontend.room.chatRoom', compact('messages', 'id', 'get_room', 'type'));
    }

    public function sendMessage(Request $request)
    {
        $data = [
            'messages' => $request['message'],
            'id' => $request['id']
        ];
        $room = \App\Models\Rooms::find($data['id']);
        $this->messagesRepository->insertChat($data, $room);
        $this->messagesRepository->sendMessage($data, 'room');

    }

    public function callback($id)
    {
        return $this->index($id);
    }

    public function outRoom($id)
    {
        $room = Rooms::find($id);
        $check = DB::table('user_room')->where('room_id', $id)
        ->where('user_id', Auth::user()->id)->get();
        // dd($check[0]);
        // $checkout = $check[0]->toArray();
        // dd($checkout);
        if(!$check->isEmpty()){
            $room->users()->detach($check[0]);
            return redirect(route('homeChat'));
        }else {
            return redirect(route('chatRoom', $id));
        }
    }
}
