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

        return redirect('/loginChat');
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
        return redirect(route('chatRoom',$id));
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
    
    public function search(Request $request)
    {
        if($request['content'] != ""){
            $search = '%'.$request['content'].'%';
            $users = DB::table('users')->where('username', 'like', $search)->get();
            $rooms = DB::table('rooms')->where('name', 'like', $search)->get();
            if ($users->isNotEmpty() || $rooms->isNotEmpty() ){
                return response()->json(['success' => true, 'users' => $users, 'rooms' => $rooms]);
            }
        }
        return response()->json(['success' => false, 'users' => "", 'rooms' => ""]);
    }

}
