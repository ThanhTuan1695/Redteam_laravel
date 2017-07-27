<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PublicLoginRequest;
use App\Repositories\UserRepository;
use DB;
use App\Models\User;
use Flash;
use Auth;

class LoginChatController extends Controller
{
    /** @var  userRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function index()
    {
        return view('frontend.login.login');
    }

    public function login(PublicLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect(route('homeChat'));
        } else {
            Flash::error('Email or Password does not exist');
            return $this->index();
        }
    }

}
