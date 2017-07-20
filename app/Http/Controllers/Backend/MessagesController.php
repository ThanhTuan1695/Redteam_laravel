<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateMessagesRequest;
use App\Http\Requests\UpdateMessagesRequest;
use App\Repositories\MessagesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MessagesController extends AppBaseController
{
    /** @var  MessagesRepository */
    private $messagesRepository;

    public function __construct(MessagesRepository $messagesRepo)
    {
        $this->messagesRepository = $messagesRepo;
    }

    /**
     * Display a listing of the Messages.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messagesRepository->pushCriteria(new RequestCriteria($request));
        $messages = $this->messagesRepository->all();

        return view('backend.messages.index')
            ->with('messages', $messages);
    }

    /**
     * Show the form for creating a new Messages.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.messages.create');
    }

    /**
     * Store a newly created Messages in storage.
     *
     * @param CreateMessagesRequest $request
     *
     * @return Response
     */
    public function store(CreateMessagesRequest $request)
    {
        $input = $request->all();

        $messages = $this->messagesRepository->create($input);

        Flash::success('Messages saved successfully.');

        return redirect(route('messages.index'));
    }

    /**
     * Display the specified Messages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('Messages not found');

            return redirect(route('messages.index'));
        }

        return view('backend.messages.show')->with('messages', $messages);
    }

    /**
     * Show the form for editing the specified Messages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('Messages not found');

            return redirect(route('messages.index'));
        }

        return view('backend.messages.edit')->with('messages', $messages);
    }

    /**
     * Update the specified Messages in storage.
     *
     * @param  int              $id
     * @param UpdateMessagesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessagesRequest $request)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('Messages not found');

            return redirect(route('messages.index'));
        }

        $messages = $this->messagesRepository->update($request->all(), $id);

        Flash::success('Messages updated successfully.');

        return redirect(route('messages.index'));
    }

    /**
     * Remove the specified Messages from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            Flash::error('Messages not found');

            return redirect(route('messages.index'));
        }

        $this->messagesRepository->delete($id);

        Flash::success('Messages deleted successfully.');

        return redirect(route('messages.index'));
    }
}
