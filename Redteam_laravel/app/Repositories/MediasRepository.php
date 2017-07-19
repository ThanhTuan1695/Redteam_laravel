<?php

namespace App\Repositories;

use App\Models\Medias;
use InfyOm\Generator\Common\BaseRepository;

class MediasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'url',
        'id_msg'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Medias::class;
    }
}
