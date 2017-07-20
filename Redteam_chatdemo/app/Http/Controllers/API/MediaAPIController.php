<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMediaAPIRequest;
use App\Http\Requests\API\UpdateMediaAPIRequest;
use App\Models\Media;
use App\Repositories\MediaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MediaController
 * @package App\Http\Controllers\API
 */

class MediaAPIController extends AppBaseController
{
    /** @var  MediaRepository */
    private $mediaRepository;

    public function __construct(MediaRepository $mediaRepo)
    {
        $this->mediaRepository = $mediaRepo;
    }

    /**
     * Display a listing of the Media.
     * GET|HEAD /media
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->mediaRepository->pushCriteria(new RequestCriteria($request));
        $this->mediaRepository->pushCriteria(new LimitOffsetCriteria($request));
        $media = $this->mediaRepository->all();

        return $this->sendResponse($media->toArray(), 'Media retrieved successfully');
    }

    /**
     * Store a newly created Media in storage.
     * POST /media
     *
     * @param CreateMediaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMediaAPIRequest $request)
    {
        $input = $request->all();

        $media = $this->mediaRepository->create($input);

        return $this->sendResponse($media->toArray(), 'Media saved successfully');
    }

    /**
     * Display the specified Media.
     * GET|HEAD /media/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Media $media */
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        return $this->sendResponse($media->toArray(), 'Media retrieved successfully');
    }

    /**
     * Update the specified Media in storage.
     * PUT/PATCH /media/{id}
     *
     * @param  int $id
     * @param UpdateMediaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMediaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Media $media */
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        $media = $this->mediaRepository->update($input, $id);

        return $this->sendResponse($media->toArray(), 'Media updated successfully');
    }

    /**
     * Remove the specified Media from storage.
     * DELETE /media/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Media $media */
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        $media->delete();

        return $this->sendResponse($id, 'Media deleted successfully');
    }
}
