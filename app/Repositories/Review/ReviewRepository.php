<?php

namespace App\Repositories\Review;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Review\ReviewRepositoryInterface;
use App\Review;

class ReviewRepository extends RepositoryEloquent implements ReviewRepositoryInterface
{
    public $perPage;

    public function __construct(Review $review)
    {
        $this->model = $review;
        $this->perPage = $this->model::PERPAGE;
    }

}
