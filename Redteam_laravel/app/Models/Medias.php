<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Medias
 * @package App\Models
 * @version July 19, 2017, 4:56 am UTC
 */
class Medias extends Model
{
    use SoftDeletes;

    public $table = 'medias';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'url',
        'id_msg'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_msg' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'url' => 'required',
        'id_msg' => 'required'
    ];

    
}
