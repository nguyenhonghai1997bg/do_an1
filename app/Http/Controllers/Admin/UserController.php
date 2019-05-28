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

    public function listNewUsers()
    {
        $users = $this->userRepository->listNewUsers();

        return view('admin.users.new', compact('users'));
    }

    public function show()
    {
    }

    public function editProfile()
    {
        return view('admin.users.profile');
    }

    public function updateProfile(Request $request)
    {
        $data = [];
        $request->validate([
            'name' => 'required|min:3|max:191|string',
            'address' => 'required|string|min:6|max:191',
            'phone' => 'regex:/(0)[0-9]{9}/',
        ]);
        $data = $request->only(['name', 'address', 'phone', 'birth_day']);
        if ($request->password) {
            $request->validate([
                'password' => 'required|string|min:6|max:191|confirmed',
            ]);
            $data['password'] = \Hash::make($request->password);
        } else {
            $data['password'] = \Auth::user()->password;
        }
        $user = $this->userRepository->update($data, \Auth::user()->id);

        return redirect()->route('admin.edit_profile', compact('user'))->with('status', __('users.updated'));
    }
}
