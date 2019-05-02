<?php

namespace App\Repositories\Catalog;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Catalog\CatalogRepositoryInterface;
use App\Catalog;

class CatalogRepository extends RepositoryEloquent implements CatalogRepositoryInterface
{
    public $perPage;

    public function __construct(Catalog $catalog)
    {
        $this->model = $catalog;
        $this->perPage = $this->model::PERPAGE;
    }

    public function search($key)
    {
    	return $this->model->where('name', 'like', '%' . $key . '%');
    }
}
