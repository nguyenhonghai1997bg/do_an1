<?php

namespace App\Repositories\Role;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Role;

class RoleRepository extends RepositoryEloquent implements RoleRepositoryInterface
{
    public $perPage;

    public function __construct(Role $role)
    {
        $this->model = $role;
        $this->perPage = $this->model::PERPAGE;
    }

    public function search($key)
    {
    	return $this->model->where('name', 'like', '%' . $key . '%');
    }
}
