<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;
use App\Models\Rooms;
use App\Models\User;
use App\Repositories\RoomsRepository;
use Flash;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;

class RoomsController extends AppBaseController
{
    /** @var  RoomsRepository */
    private $roomsRepository;

    public function __construct(RoomsRepository $roomsRepo)
    {
        $this->roomsRepository = $roomsRepo;
    }

    /**
     * Display a listing of the Rooms.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->roomsRepository->pushCriteria(new RequestCriteria($request));
        $rooms = $this->roomsRepository->all();

        return view('backend.rooms.index')
            ->with('rooms', $rooms);
    }

    /**
     * Show the form for creating a new Rooms.
     *
     * @return Response
     */
    public function create()
    {

        $listUser = User::pluck('username','id');
        return view('backend.rooms.create',compact('listUser'));
    }

    /**
     * Store a newly created Rooms in storage.
     *
     * @param CreateRoomsRequest $request
     *
     * @return Response
     */
    public function store(CreateRoomsRequest $request)
    {
        $input = $request->all();

        $rooms = $this->roomsRepository->create($input);
        $rooms->users()->attach($request['user_id']);
        Flash::success('Rooms saved successfully.');

        return redirect(route('rooms.index'));
    }

    /**
     * Display the specified Rooms.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rooms = $this->roomsRepository->findWithoutFail($id);

        if (empty($rooms)) {
            Flash::error('Rooms not found');
            return redirect(route('rooms.index'));
        }

        return view('backend.rooms.show')->with('rooms', $rooms);
    }

    /**
     * Show the form for editing the specified Rooms.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rooms = $this->roomsRepository->findWithoutFail($id);
        //$listUser = User::where('id', $rooms->belongtoUser->id)->pluck('name','id');
        $listUser = $rooms->users()->pluck('username','id');
       //select * from users where id in select user_id from User_room where room_id = ??
       //  dd($rooms->users->toArray());

        if (empty($rooms)) {
            Flash::error('Rooms not found');

            return redirect(route('rooms.index'));
        }

        return view('backend.rooms.edit',compact(['listUser','rooms']));
    }

    /**
     * Update the specified Rooms in storage.
     *
     * @param  int              $id
     * @param UpdateRoomsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoomsRequest $request)
    {
        $rooms = $this->roomsRepository->findWithoutFail($id);

        if (empty($rooms)) {
            Flash::error('Rooms not found');

            return redirect(route('rooms.index'));
        }

        $rooms = $this->roomsRepository->update($request->all(), $id);

        Flash::success('Rooms updated successfully.');

        return redirect(route('rooms.index'));
    }

    /**
     * Remove the specified Rooms from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rooms = $this->roomsRepository->findWithoutFail($id);

        if (empty($rooms)) {
            Flash::error('Rooms not found');

            return redirect(route('rooms.index'));
        }

        $this->roomsRepository->delete($id);

        Flash::success('Rooms deleted successfully.');

        return redirect(route('rooms.index'));
    }

    function users($id){
        $room = Rooms::find($id);
        $users = $room->users;
        return view('backend.rooms.user.index', compact('room', 'users'));
    }

    public function destroyUser($id, $userId)
    {
        $room = Rooms::find($id);
        $check = DB::table('user_room')->where('room_id', $id)
            ->where('user_id', $userId)->get();
        if ($check->isEmpty()) {
            Flash::error('User not found');
            return redirect(route('room.user.index', $id));
        }

        $room->users()->detach($check[0]);
        Flash::success('User out Room successfully.');
        return redirect(route('room.user.index', $id));
    }
}
