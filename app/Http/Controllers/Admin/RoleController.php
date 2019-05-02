<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $userRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * show all roles
     * @return view
     */
    public function index(Request $request)
    {
        $key = $request->search;
        if (!empty($key)) {
            $roles = $this->roleRepository->search($key)->orderBy('id', 'DESC')->paginate($this->roleRepository->perPage);
        } else {
            $roles = $this->roleRepository->orderBy('id', 'DESC')->paginate($this->roleRepository->perPage);
        }

        return view('admin.roles.index', compact('roles', 'key'));
    }

    public function destroy($id)
    {
        $role = $this->roleRepository->destroy($id);

        return $role;
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $role = $this->roleRepository->update($data, $id);

        return $role;
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $role = $this->roleRepository->create($data);

        return $role;
    }
}
