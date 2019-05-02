<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryEloquent;
use App\Repositories\User\UserRepositoryInterface;
use App\User;

class UserRepository extends RepositoryEloquent implements UserRepositoryInterface
{
    public $perPage;

    public function __construct(User $user)
    {
        $this->model = $user;
        $this->perPage = $this->model::PERPAGE;
    }

    public function getByRole($id)
    {
        return $this->model->where('role_id', $id)->orderBy('id', 'DESC')->paginate($this->perPage);
    }

    public function searchUsers($key, $role_id)
    {
        return $this->model->where('role_id', $role_id)
                            ->where(function($query) use ($key, $role_id) {
                                return $query->where('name', 'like', '%' . $key . '%')->orWhere('email', 'like', '%' . $key . '%')->orWhere('phone', 'like', '%' . $key . '%');
                            })->orderBy('id', 'DESC')->paginate($this->perPage);
    }
}
