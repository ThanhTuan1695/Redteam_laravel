<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Repositories\UserRepository;
use App\Models\Rooms;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use LRedis;
use Reponse;
use Flash;
use App\Http\Requests\UpdateUserRequest;

class ManagerController extends Controller
{
    /** @var  userRepository */
    private $userRepository;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function index()
    {
        return view('frontend.manager.wellcome');
    }

    public function logoutPublic(Request $request)
    {
        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/public/loginChat');
    }

    public function chatUser($id)
    {
        return view('frontend.manager.chatUser');
    }

    public function chatRoom($id)
    {
        $get_room = Rooms::find($id);
        $messages = $get_room->messages;
        $user_id = Auth::user()->id;
        $check = DB::table('user_room')->where('user_id', '=', $user_id)
        ->where('room_id', '=', $id)->get();
        $data = array('user_id' => $user_id, 'room_id' => $id);
        if($check->isEmpty())
        {
            DB::table('user_room')->insert($data);
        }
        
        return view('frontend.manager.chatRoom',compact('messages', 'id', 'get_room'));
    }

    public function sendMessage(Request $request){
        $content = e($request->input('message'));
        $data = new Messages(['content' => $content, 'user_id' => Auth::user()->id]);
        Rooms::find($request->input('room_id'))->messages()->save($data);
        $message2 = Messages::with('user')->orderBy('id', 'desc')->first();
        $redis = LRedis::connection();
        $redis->publish('message', $message2);
    }

    public function chooseUser(Request $request, $id)
    {
        $user_id = DB::table('user_room')->select('user_id')->where('room_id', $id)->get();
        $arr = $user_id->toArray();
        $arr1 = array_pluck($arr, 'user_id');
        $users = DB::table('users')->whereNotIn('id', $arr1)->get();
        return view('frontend.manager.addUser', compact('users', 'id'));
    }

    public function addUser(Request $request, $id)
    {
        $list_user = $request['check_list'];
        $room = Rooms::find($id);
        $room->users()->attach($list_user);
        return $this->chatRoom($id);
    }

    public function profileUser()
    {
        $user = User::find(Auth::user()->id);
        return view('frontend.manager.profileUser')->with('user', $user);
    }

    
    public function updateProfile(UpdateUserRequest $request, $id)
    {
        if($this->userRepository->editUser($request, $id)){
            Flash::success('User updated successfully.');
            return redirect(route('homeChat'));
        }else {
            Flash::error('Username is exist.');

            return $this->profileUser();
             
        }
    }
}
