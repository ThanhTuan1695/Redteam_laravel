<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ownRooms()
    {
        return $this->hasMany('App\Models\Rooms', 'user_id');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Models\Rooms', 'user_room','user_id', 'room_id');
    }
    
}
