<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMessagesAPIRequest;
use App\Http\Requests\API\UpdateMessagesAPIRequest;
use App\Models\Messages;
use App\Repositories\MessagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MessagesController
 * @package App\Http\Controllers\API
 */

class MessagesAPIController extends AppBaseController
{
    /** @var  MessagesRepository */
    private $messagesRepository;

    public function __construct(MessagesRepository $messagesRepo)
    {
        $this->messagesRepository = $messagesRepo;
    }

    /**
     * Display a listing of the Messages.
     * GET|HEAD /messages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->messagesRepository->pushCriteria(new RequestCriteria($request));
        $this->messagesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $messages = $this->messagesRepository->all();

        return $this->sendResponse($messages->toArray(), 'Messages retrieved successfully');
    }

    /**
     * Store a newly created Messages in storage.
     * POST /messages
     *
     * @param CreateMessagesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMessagesAPIRequest $request)
    {
        $input = $request->all();

        $messages = $this->messagesRepository->create($input);

        return $this->sendResponse($messages->toArray(), 'Messages saved successfully');
    }

    /**
     * Display the specified Messages.
     * GET|HEAD /messages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Messages $messages */
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            return $this->sendError('Messages not found');
        }

        return $this->sendResponse($messages->toArray(), 'Messages retrieved successfully');
    }

    /**
     * Update the specified Messages in storage.
     * PUT/PATCH /messages/{id}
     *
     * @param  int $id
     * @param UpdateMessagesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMessagesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Messages $messages */
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            return $this->sendError('Messages not found');
        }

        $messages = $this->messagesRepository->update($input, $id);

        return $this->sendResponse($messages->toArray(), 'Messages updated successfully');
    }

    /**
     * Remove the specified Messages from storage.
     * DELETE /messages/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Messages $messages */
        $messages = $this->messagesRepository->findWithoutFail($id);

        if (empty($messages)) {
            return $this->sendError('Messages not found');
        }

        $messages->delete();

        return $this->sendResponse($id, 'Messages deleted successfully');
    }
}
