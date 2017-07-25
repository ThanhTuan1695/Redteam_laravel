<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Rooms;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class ManagerController extends Controller
{
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
        return view('frontend.manager.chatRoom');
    }
}
