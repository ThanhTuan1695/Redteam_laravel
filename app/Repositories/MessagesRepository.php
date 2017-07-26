<?php

namespace App\Repositories;

use App\Models\Messages;
use App\Models\Single;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

class MessagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'user_id',
        'messageable_id',
        'messageable_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Messages::class;
    }

    public function insertChat($data)  
    {
        $user_user = Single::find($data['idCap']);
        $mes = new Messages();
        $mes->user_id = Auth::user()->id;
        $mes->content = $data['messages'];
        $bl= $user_user->messages()->save($mes);
    }
}
