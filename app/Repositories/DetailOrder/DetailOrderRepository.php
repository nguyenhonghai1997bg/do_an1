<?php

namespace App\Repositories\DetailOrder;

use App\Repositories\RepositoryEloquent;
use App\Repositories\DetailOrder\DetailOrderRepositoryInterface;
use App\DetailOrder;

class DetailOrderRepository extends RepositoryEloquent implements DetailOrderRepositoryInterface
{
    public $perPage;

    public function __construct(DetailOrder $detailOrder)
    {
        $this->model = $detailOrder;
        $this->perPage = $this->model::PERPAGE;
    }

}
