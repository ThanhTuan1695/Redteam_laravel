<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Repositories\MediaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MediaController extends AppBaseController
{
    /** @var  MediaRepository */
    private $mediaRepository;

    public function __construct(MediaRepository $mediaRepo)
    {
        $this->mediaRepository = $mediaRepo;
    }

    /**
     * Display a listing of the Media.
     *
     * @param Request $request
     * @return Response
     */
    public function index($id)
    {
        $medias = $this->mediaRepository->listMedia($id);

        return view('backend.rooms.media.index', compact('id', 'medias'));
    }

  

    /**
     * Display the specified Media.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, $mediaId)
    {
        $media = $this->mediaRepository->findWithoutFail($mediaId);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('media.index'));
        }

        return view('backend.rooms.media.show', compact('media', 'id'));
    }

    /**
     * Show the form for editing the specified Media.
     *
     * @param  int $id
     *
     * @return Response
     */
    
    /**
     * Remove the specified Media from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, $mediaId)
    {
        $media = $this->mediaRepository->findWithoutFail($mediaId);

        if (empty($media)) {
            Flash::error('Media not found');

            return redirect(route('media.index', $id));
        }

        $this->mediaRepository->delete($mediaId);

        Flash::success('Media deleted successfully.');

        return redirect(route('media.index',$id));
    }
}
