<?php

namespace App\Repositories;

use App\Models\PayrollRun;
use App\Repositories\Contracts\PayrollRunRepositoryInterface;

class PayrollRunRepository extends BaseRepository implements PayrollRunRepositoryInterface
{
    public function __construct(PayrollRun $model)
    {
        parent::__construct($model);
    }

    public function getByPeriod(int $month, int $year)
    {
        return $this->model->where('month', $month)
            ->where('year', $year)
            ->first();
    }

    public function getByStatus(string $status)
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getLatest()
    {
        return $this->model->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->first();
    }
}
