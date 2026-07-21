<?php

namespace App\Repositories;

use App\Models\PerformanceReview;
use App\Repositories\Contracts\PerformanceReviewRepositoryInterface;

class PerformanceReviewRepository extends BaseRepository implements PerformanceReviewRepositoryInterface
{
    public function __construct(PerformanceReview $model)
    {
        parent::__construct($model);
    }
}
