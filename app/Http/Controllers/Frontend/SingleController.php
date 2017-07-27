<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\Rooms;
use App\Models\Single;
use App\Repositories\MessagesRepository;
use App\Repositories\SingleRepository;
use App\Repositories\UserRepository;
use Auth;
use DB;
use Illuminate\Broadcasting\connection;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use LRedis;
use Reponse;

class SingleController extends Controller
{
    private $userRepository;
    private $messagesRepository;
    private $singleRepository;
    public function __construct(UserRepository $userRepo,MessagesRepository $mesRepo,SingleRepository $singleRepo)
    {
        $this->userRepository = $userRepo;
        $this->messagesRepository = $mesRepo;
        $this->singleRepository = $singleRepo;
    }
    public function index($id)
    {

        $user = $this->userRepository->getUserById($id);  
        $user_user = $this->singleRepository->findSingleId(Auth::user()->id,$id);
        if ($user_user == null) {
            $user_user = $this->singleRepository->addSingleId(Auth::user()->id,$id);
        }
        $mes = $user_user->messages;
        $type ="user-user";
        $avatarSender =Auth::user()->avatar;
         return view('frontend.single.chatUser',compact('user','mes','type','avatarSender'))->with('idCap',$user_user->id);
    }

    public function sendMessage(Request $req)        
    {

        $data =[
                    'messages' => $req['message'],
                    'idCap'    => $req['idCap'],
                    'avatarSender'=>Auth::user()->avatar,
                    'usernameSender' => Auth::user()->username,
                ];
        $this->messagesRepository->insertChat($data);
        $data['messagesType'] = 'user-user';
        LRedis::publish('message', json_encode($data));
        return response()->json([]);
    }


}
