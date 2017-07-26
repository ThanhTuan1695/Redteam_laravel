<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Rooms;
use App\Models\Messages;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use LRedis;
use Reponse;

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

   

   
}
