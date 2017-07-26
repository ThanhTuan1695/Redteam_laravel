<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Messages
 * @package App\Models
 * @version July 19, 2017, 9:12 am UTC
 */
class Messages extends Model
{
    use SoftDeletes;

    public $table = 'messages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'user_id',
        'messageable_id',
        'messageable_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'user_id' => 'integer',
        'messageable_id' => 'integer',
        'messageable_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content' => 'required'
    ];

    public function messageable()
    {
        return $this->morphTo();
    }


    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
