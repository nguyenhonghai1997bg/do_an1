<?php

namespace App\Repositories\Category;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Category;

class CategoryRepository extends RepositoryEloquent implements CategoryRepositoryInterface
{
    public $perPage;

    public function __construct(Category $category)
    {
        $this->model = $category;
        $this->perPage = $this->model::PERPAGE;
    }

    public function search($key, $catalog_id)
    {
        if ($catalog_id) {
            return $this->model->where('catalog_id', $catalog_id)->where(function($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%');
            });
        } else {
            return $this->model->where('name', 'like', '%' . $key . '%');
        }
    }
}
