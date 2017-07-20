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
        $data = array(
            '_token' => $request['_token'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role' => $request['role']);
        $this->create($data);
        return true;

    }

    public function editUser($request, $id)
    {
        if ($this->checkPassword($request['current-password'])) {
            if ($request['password'] != '') {
                $data = array('name' => $request['name']);
                $this->update($data, $id);
                $this->update(['password' => Hash::make($request['password'])], $id);
            } else {
                $data = array('name' => $request['name']);
                $this->update($data, $id);
            }
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($current_password)
    {
        if (Hash::check($current_password, Auth::User()->password)) {
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
