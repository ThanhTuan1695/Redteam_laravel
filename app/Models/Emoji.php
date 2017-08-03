<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Media
 * @package App\Models
 * @version July 19, 2017, 9:13 am UTC
 */
class Emoji extends Model
{

    public $table = 'emoji';
    



    public $fillable = [
        'url',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'url' => 'string',
    ];

}
