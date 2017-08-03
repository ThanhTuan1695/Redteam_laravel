<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\Rooms;
use Illuminate\Support\Facades\App;
use InfyOm\Generator\Common\BaseRepository;

class MediaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'url',
        'mgs_id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Media::class;
    }
    public  function listMedia($id){
        $room = Rooms::find($id);
        $meidas = $room->medias;
        return $meidas;
    }
}
