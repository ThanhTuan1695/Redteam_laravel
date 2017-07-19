<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMediasRequest;
use App\Http\Requests\UpdateMediasRequest;
use App\Repositories\MediasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MediasController extends AppBaseController
{
    /** @var  MediasRepository */
    private $mediasRepository;

    public function __construct(MediasRepository $mediasRepo)
    {
        $this->mediasRepository = $mediasRepo;
    }

    /**
     * Display a listing of the Medias.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->mediasRepository->pushCriteria(new RequestCriteria($request));
        $medias = $this->mediasRepository->all();

        return view('medias.index')
            ->with('medias', $medias);
    }

    /**
     * Show the form for creating a new Medias.
     *
     * @return Response
     */
    public function create()
    {
        return view('medias.create');
    }

    /**
     * Store a newly created Medias in storage.
     *
     * @param CreateMediasRequest $request
     *
     * @return Response
     */
    public function store(CreateMediasRequest $request)
    {
        $input = $request->all();

        $medias = $this->mediasRepository->create($input);

        Flash::success('Medias saved successfully.');

        return redirect(route('medias.index'));
    }

    /**
     * Display the specified Medias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $medias = $this->mediasRepository->findWithoutFail($id);

        if (empty($medias)) {
            Flash::error('Medias not found');

            return redirect(route('medias.index'));
        }

        return view('medias.show')->with('medias', $medias);
    }

    /**
     * Show the form for editing the specified Medias.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $medias = $this->mediasRepository->findWithoutFail($id);

        if (empty($medias)) {
            Flash::error('Medias not found');

            return redirect(route('medias.index'));
        }

        return view('medias.edit')->with('medias', $medias);
    }

    /**
     * Update the specified Medias in storage.
     *
     * @param  int              $id
     * @param UpdateMediasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMediasRequest $request)
    {
        $medias = $this->mediasRepository->findWithoutFail($id);

        if (empty($medias)) {
            Flash::error('Medias not found');

            return redirect(route('medias.index'));
        }

        $medias = $this->mediasRepository->update($request->all(), $id);

        Flash::success('Medias updated successfully.');

        return redirect(route('medias.index'));
    }

    /**
     * Remove the specified Medias from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $medias = $this->mediasRepository->findWithoutFail($id);

        if (empty($medias)) {
            Flash::error('Medias not found');

            return redirect(route('medias.index'));
        }

        $this->mediasRepository->delete($id);

        Flash::success('Medias deleted successfully.');

        return redirect(route('medias.index'));
    }
}
