<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Single extends Model
{
    public $table = 'user_user';
    public $timestamps = false;

    public function messages()
    {
        return $this->morphMany('App\Models\Messages', 'messageable');
    }

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediable');
    }
}
