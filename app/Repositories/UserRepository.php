<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Auth;
use Illuminate\Support\Facades\Session;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use File;


class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'role',
        'avatar'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function addUser($request)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $url = 'backend/images/upload';
            $imagename=time() . '.'. $avatar->getClientOriginalExtension();
            $data = array(
                '_token' => $request['_token'],
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'avatar' => $imagename,
                'role' => $request['role']);

            $avatar->move(public_path($url), $imagename);
        }else {
            return false;
        }
        $this->create($data);
        return true;
    }

    public function editUser($request, $id)
    {
        $data = $this->checkImg($request,$id);
        if ($this->checkPassword($request['current-password'])) {
            if ($request['password'] != '') {
                $this->update($data, $id);
                $this->update(['password' => Hash::make($request['password'])], $id);
            } else {
                $this->update($data, $id);
            }
            return true;
        } else {
            return false;
        }
    }

    public function checkImg($request, $id) {
        if($request->hasFile('avatar')) {
            $url = '/backend/images/upload/';

            $image = \DB::table('users')->where('id', $id)->first();
            $file= $image->avatar;
            $filename = public_path().$url.$file;
            File::delete($filename);

            $avatar = $request->file('avatar');
            $imagename=time() . '.'. $avatar->getClientOriginalExtension();
            $data = array(
                'name' => $request['name'],
                'avatar' => $imagename);

            $avatar->move(public_path($url), $imagename);
            return $data;
        } else {
            $data = array('name' => $request['name']);
            return $data;
        }
    }

    public function checkPassword($current_password)
    {
        if (Hash::check($current_password, Auth::user()->password)) {
            return true;
        } else {
            return false;
        }
    }


    // Func frontend

    public function registerUser($request)
    {
        $data = array(
            '_token' => $request['_token'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => 2);
        $this->create($data);
        //if isset ($data)
        return true;
    }

    public function userLogin($request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return true;
        } else {
            return false;
        }
    }

}
