<?php

namespace App\Repositories;


use App\Models\Single;
use Auth;
use DB;
use File;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use InfyOm\Generator\Common\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;


class SingleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_first_id',
        'user_second_id',
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Single::class;
    }

    public function addSingleId($user_first_id,$user_second_id)
    {
            $single = new Single();
            $single->user_first_id = $user_first_id;
            $single->user_second_id = $user_second_id;
            $single->save();
            return $single;
    }
    public function findSingleId($user_first_id,$user_second_id)
    {
       $user_single = Single::where([
                                        ['user_first_id','=',$user_first_id],
                                        ['user_second_id','=', $user_second_id]
                                    ])
                            ->orwhere([
                                        ['user_second_id','=',$user_first_id ],
                                        ['user_first_id','=',$user_second_id],
                                    ])->first();
        return $user_single;
    }

  

}
