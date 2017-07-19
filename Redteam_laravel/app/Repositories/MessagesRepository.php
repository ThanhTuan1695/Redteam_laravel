<?php

namespace App\Repositories;

use App\Models\Messages;
use InfyOm\Generator\Common\BaseRepository;

class MessagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'id_user',
        'id_room',
        'id_single'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Messages::class;
    }
}
