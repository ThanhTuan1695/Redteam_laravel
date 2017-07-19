<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRoomsAPIRequest;
use App\Http\Requests\API\UpdateRoomsAPIRequest;
use App\Models\Rooms;
use App\Repositories\RoomsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class RoomsController
 * @package App\Http\Controllers\API
 */

class RoomsAPIController extends AppBaseController
{
    /** @var  RoomsRepository */
    private $roomsRepository;

    public function __construct(RoomsRepository $roomsRepo)
    {
        $this->roomsRepository = $roomsRepo;
    }

    /**
     * Display a listing of the Rooms.
     * GET|HEAD /rooms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->roomsRepository->pushCriteria(new RequestCriteria($request));
        $this->roomsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $rooms = $this->roomsRepository->all();

        return $this->sendResponse($rooms->toArray(), 'Rooms retrieved successfully');
    }

    /**
     * Store a newly created Rooms in storage.
     * POST /rooms
     *
     * @param CreateRoomsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRoomsAPIRequest $request)
    {
        $input = $request->all();

        $rooms = $this->roomsRepository->create($input);

        return $this->sendResponse($rooms->toArray(), 'Rooms saved successfully');
    }

    /**
     * Display the specified Rooms.
     * GET|HEAD /rooms/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Rooms $rooms */
        $rooms = $this->roomsRepository->findWithoutFail($id);

        if (empty($rooms)) {
            return $this->sendError('Rooms not found');
        }

        return $this->sendResponse($rooms->toArray(), 'Rooms retrieved successfully');
    }

    /**
     * Update the specified Rooms in storage.
     * PUT/PATCH /rooms/{id}
     *
     * @param  int $id
     * @param UpdateRoomsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoomsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Rooms $rooms */
        $rooms = $this->roomsRepository->findWithoutFail($id);

        if (empty($rooms)) {
            return $this->sendError('Rooms not found');
        }

        $rooms = $this->roomsRepository->update($input, $id);

        return $this->sendResponse($rooms->toArray(), 'Rooms updated successfully');
    }

    /**
     * Remove the specified Rooms from storage.
     * DELETE /rooms/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Rooms $rooms */
        $rooms = $this->roomsRepository->findWithoutFail($id);

        if (empty($rooms)) {
            return $this->sendError('Rooms not found');
        }

        $rooms->delete();

        return $this->sendResponse($id, 'Rooms deleted successfully');
    }
}
