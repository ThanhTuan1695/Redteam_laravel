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
        if($get_room == null ){
            return back();
        }
        $messages = $get_room->messages;
        $user_id = Auth::user()->id;
        $check = DB::table('user_room')->where('user_id', $user_id)
            ->where('room_id', $id)->get();
        $data = array('user_id' => $user_id, 'room_id' => $id);
        if ($check->isEmpty()) {
            DB::table('user_room')->insert($data);
        }
        $type = 'room';
        $url = url('public/sendmessage');

        $receiver_id = $id;
        $medias = $get_room->medias()->get(['url','type','name'])->unique('url');
        $listUsers = $get_room->users;
        return view('frontend.room.chatRoom', compact('messages', 'id', 'get_room', 'type','url','medias','receiver_id','listUsers'));


    }

    public function sendMessage(Request $request)
    {
        $room = \App\Models\Rooms::find($request['id']);
        $this->messagesRepository->insertChat($request, $room);
        $data = $this->messagesRepository->sendMessage($request, 'room');
        return $data;
    }



    public function outRoom($id)
    {
        $room = Rooms::find($id);
        if(Auth::user()->id == $room->user_id) {
            $listUser_id = DB::table('user_room')->select('user_id')->where('room_id', $id)
            ->where('user_id', '!=', Auth::user()->id)->get();
            $listUserID = array_pluck($listUser_id->toArray(),'user_id');
            $listUser = User::all()->whereIn('id',$listUserID);
            return view('frontend.room.selectAdmin', compact('listUser', 'id'));
        }else {
            $check = DB::table('user_room')->where('room_id', $id)
            ->where('user_id', Auth::user()->id)->get();
            if(!$check->isEmpty()){
                $room->users()->detach($check[0]);
                return redirect(route('homeChat'));
            }else {
                return redirect(route('chatRoom', $id));
            }
        }
    }

    public function changeAdmin(Request $request,$id){
        $user_id = (int) $request->select;
        $update_room = DB::table('rooms')->where('id',$id)->update(['user_id' => $user_id]);
        $room = Rooms::find($id);
        $check = DB::table('user_room')->where('room_id', $id)
                ->where('user_id', Auth::user()->id)->get();
        dd($check);
        $room->users()->detach($check[0]);
        return redirect(route('homeChat'));
    }

    public function delUserRoom(Request $request)

    {
     
        $id = $request['id'];
        $user_id = $request['user_id'];
        $room = Rooms::find($id);
        $check = DB::table('user_room')->where('room_id', $id)
                ->where('user_id', $user_id)->get();
        $room->users()->detach($check[0]);

    }
    public function callback($id)
    {
        return $this->index($id);
    }

    public function callback($id)
    {
        return $this->index($id);
    }

}
