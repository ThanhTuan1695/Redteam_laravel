<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Messages
 * @package App\Models
 * @version July 19, 2017, 4:54 am UTC
 */
class Messages extends Model
{
    use SoftDeletes;

    public $table = 'messages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'id_user',
        'id_room',
        'id_single'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_user' => 'integer',
        'id_room' => 'integer',
        'id_single' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content' => 'required',
        'id_user' => 'required',
        'id_room' => 'required',
        'id_single' => 'required'
    ];

    
}
