<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Single extends Model
{
    public $table = 'user_user';

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'single_id');
    }
}
