<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Rooms
 * @package App\Models
 * @version July 19, 2017, 9:10 am UTC
 */
class Rooms extends Model
{
    use SoftDeletes;

    public $table = 'rooms';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'user_id',
        'description',
        'type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'user_id' => 'integer',
        'description' => 'string',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'user_id' => 'required',
        'description' => 'required',
        'type' => 'required',
    ];

    public function belongtoUser(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User','user_room','room_id','user_id');
    }

    public function messages()
    {
        return $this->morphMany('App\Models\Messages', 'messageable');
    }

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }
}
