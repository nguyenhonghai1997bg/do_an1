<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }
    /**
     * show all users
     * @return view
     */
    public function index(Request $request)
    {
        $key = $request->search;
        $role_id = $request->role;
        if (!empty($key) || !empty($role_id)) {
            $users = $this->userRepository->searchUsers($key, $role_id);
        } else {
            $users = $this->userRepository->orderBy('id', 'DESC')->paginate($this->userRepository->perPage);
        }
        $roles = $this->roleRepository->all(['id', 'name']);

        return view('admin.users.index', compact('users', 'key', 'roles', 'role_id'));
    }

    public function destroy($id)
    {
        return $this->userRepository->destroy($id);
    }

    public function edit($id)
    {
        $user = $this->userRepository->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function create()
    {
        $roles = $this->roleRepository->all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = \Hash::make('12345678');
        $role = $this->userRepository->create($data);

        return redirect()->route('users.index')->with('status', __('users.created'));
    }

    public function show(){

    }

    // public function searchUsers($key)
    // {
    //     $users = $this->userRepository->searchUsers($key);

    //     return $users;
    // }
}
