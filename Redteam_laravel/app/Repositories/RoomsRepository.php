<?php

namespace App\Repositories;

use App\Models\Rooms;
use InfyOm\Generator\Common\BaseRepository;

class RoomsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'id_user'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Rooms::class;
    }
}
