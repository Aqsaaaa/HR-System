<?php

namespace App\Repositories\Contracts;

interface PayrollRunRepositoryInterface extends RepositoryInterface
{
    public function getByPeriod(int $month, int $year);
    public function getByStatus(string $status);
    public function getLatest();
}
