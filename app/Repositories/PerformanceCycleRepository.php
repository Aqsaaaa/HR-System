<?php

namespace App\Repositories;

use App\Models\PerformanceCycle;
use App\Repositories\Contracts\PerformanceCycleRepositoryInterface;

class PerformanceCycleRepository extends BaseRepository implements PerformanceCycleRepositoryInterface
{
    public function __construct(PerformanceCycle $model)
    {
        parent::__construct($model);
    }
}
