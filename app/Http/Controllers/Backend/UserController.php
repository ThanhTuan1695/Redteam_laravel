<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserController extends Controller
{
    /** @var  userRepository */
    private $userRepository;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the rooms.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $user = $this->userRepository->all();
        $currentUserId = $request->user()->id;

        return view('backend.users.index', compact('user', 'currentUserId'));
    }

    /**
     * Show the form for creating a new rooms.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created rooms in storage.
     *
     * @param CreateuserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        if($this->userRepository->addUser($request)){
            Flash::success('User create successfully.');
            return redirect(route('users.index'));
        }else{
            Flash::error('Password is not correct');
            return $this->create();
        }

        
    }

    /**
     * Display the specified rooms.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
 
        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('backend.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified rooms.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {   
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('user not found');
            return redirect(route('users.index'));
        }
        return view('backend.users.edit')->with('user', $user);
    }

    /**
     * Update the specified rooms in storage.
     *
     * @param  int              $id
     * @param UpdateroomsRequest $request
     *
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if($this->userRepository->editUser($request, $id)){
            Flash::success('User updated successfully.');
            // Flash::success('User'.config('m_const_config.update_success'));
            return redirect(route('users.index'));
        }else {
            Flash::error('Password is not correct.');
            return $this->edit($id);
             
        }
        
    }

    /**
     * Remove the specified rooms from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id); 

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }
}
