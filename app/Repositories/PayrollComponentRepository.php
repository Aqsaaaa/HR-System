<?php

namespace App\Repositories;

use App\Models\PayrollComponent;
use App\Repositories\Contracts\PayrollComponentRepositoryInterface;

class PayrollComponentRepository extends BaseRepository implements PayrollComponentRepositoryInterface
{
    public function __construct(PayrollComponent $model)
    {
        parent::__construct($model);
    }

    public function getByType(string $type)
    {
        return $this->model->where('type', $type)
            ->orderBy('sort_order')
            ->get();
    }

    public function getActive()
    {
        return $this->model->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
