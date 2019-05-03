<?php

namespace App\Repositories\Paymethod;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Paymethod\PaymethodRepositoryInterface;
use App\Paymethod;

class PaymethodRepository extends RepositoryEloquent implements PaymethodRepositoryInterface
{
    public $perPage;

    public function __construct(Paymethod $paymethod)
    {
        $this->model = $paymethod;
        $this->perPage = $this->model::PERPAGE;
    }

    public function search($key)
    {
    	return $this->model->where('name', 'like', '%' . $key . '%');
    }
}
