<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMediasAPIRequest;
use App\Http\Requests\API\UpdateMediasAPIRequest;
use App\Models\Medias;
use App\Repositories\MediasRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MediasController
 * @package App\Http\Controllers\API
 */

class MediasAPIController extends AppBaseController
{
    /** @var  MediasRepository */
    private $mediasRepository;

    public function __construct(MediasRepository $mediasRepo)
    {
        $this->mediasRepository = $mediasRepo;
    }

    /**
     * Display a listing of the Medias.
     * GET|HEAD /medias
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->mediasRepository->pushCriteria(new RequestCriteria($request));
        $this->mediasRepository->pushCriteria(new LimitOffsetCriteria($request));
        $medias = $this->mediasRepository->all();

        return $this->sendResponse($medias->toArray(), 'Medias retrieved successfully');
    }

    /**
     * Store a newly created Medias in storage.
     * POST /medias
     *
     * @param CreateMediasAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMediasAPIRequest $request)
    {
        $input = $request->all();

        $medias = $this->mediasRepository->create($input);

        return $this->sendResponse($medias->toArray(), 'Medias saved successfully');
    }

    /**
     * Display the specified Medias.
     * GET|HEAD /medias/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Medias $medias */
        $medias = $this->mediasRepository->findWithoutFail($id);

        if (empty($medias)) {
            return $this->sendError('Medias not found');
        }

        return $this->sendResponse($medias->toArray(), 'Medias retrieved successfully');
    }

    /**
     * Update the specified Medias in storage.
     * PUT/PATCH /medias/{id}
     *
     * @param  int $id
     * @param UpdateMediasAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMediasAPIRequest $request)
    {
        $input = $request->all();

        /** @var Medias $medias */
        $medias = $this->mediasRepository->findWithoutFail($id);

        if (empty($medias)) {
            return $this->sendError('Medias not found');
        }

        $medias = $this->mediasRepository->update($input, $id);

        return $this->sendResponse($medias->toArray(), 'Medias updated successfully');
    }

    /**
     * Remove the specified Medias from storage.
     * DELETE /medias/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Medias $medias */
        $medias = $this->mediasRepository->findWithoutFail($id);

        if (empty($medias)) {
            return $this->sendError('Medias not found');
        }

        $medias->delete();

        return $this->sendResponse($id, 'Medias deleted successfully');
    }
}
