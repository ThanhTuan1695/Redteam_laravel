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
    public function __construct(UserRepository $userRepo,MessagesRepository $mesRepo,SingleRepository $singleRepo){
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
        $messages = $user_user->messages;
        $type ="user-user";
        $avatarSender =Auth::user()->avatar;
        return view('frontend.single.chatUser',compact('user','messages','type'))->with('id', $user_user->id);
    }

    public function sendMessage(Request $request)
    {
        $data = [
            'messages' => $request['message'],
            'id' => $request['id']
        ];
        $user_user = Single::find($data['id']);
        $this->messagesRepository->insertChat($data, $user_user);
        $this->messagesRepository->sendMessage($data, 'user-user');
    }


}
