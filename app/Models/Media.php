<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Media
 * @package App\Models
 * @version July 19, 2017, 9:13 am UTC
 */
class Media extends Model
{
    use SoftDeletes;

    public $table = 'media';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'url',
        'mgs_id',
        'type',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'url' => 'string',
        'mgs_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'url' => 'required',
        'mgs_id' => 'required'
    ];

    public function belongtoMessage(){
        return $this->belongsTo('App\Models\Messages','mgs_id');
    }

}
