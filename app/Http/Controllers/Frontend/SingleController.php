<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\Rooms;
use App\Models\Single;
use App\Repositories\MessagesRepository;
use App\Repositories\UserRepository;
use Auth;
use DB;
use Illuminate\Broadcasting\connection;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Redis;
use LRedis;
use Reponse;

class SingleController extends Controller
{
    private $userRepository;
    private $messagesRepository;
    public function __construct(UserRepository $userRepo,MessagesRepository $mesRepo)
    {
        $this->userRepository = $userRepo;
        $this->messagesRepository = $mesRepo;
    }
    public function index($id)
    {

        $user = $this->userRepository->getUserById($id);
        
        $user_user = Single::where([
                        ['user_first_id','=',$user->id],
                        ['user_second_id','=', Auth::user()->id]
            ])->orwhere([
                        ['user_second_id','=',$user->id ],
                        ['user_first_id','=',Auth::user()->id],
                    ])->first();   
        $mes = $user_user->messages;
        $type ="user-user";
         return view('frontend.single.chatUser',compact('user','mes','type'))->with('idCap',$user_user->id);

    }

    public function sendMessage(Request $req)        
    {

        $data =[
                    'messages' => $req['message'],
                    'idCap'    => $req['idCap']
                ];
        $this->messagesRepository->insertChat($data);
        $data['messagesType'] = 'user-user';
        LRedis::publish('message', json_encode($data));
        return response()->json([]);
    }


}
