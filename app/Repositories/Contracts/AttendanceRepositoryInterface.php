<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface AttendanceRepositoryInterface extends RepositoryInterface
{
    public function findByEmployeeAndDate(int $employeeId, string $date);
    public function getTodayByEmployee(int $employeeId);
    public function getByEmployeeAndPeriod(int $employeeId, string $start, string $end);
    public function getByDate(string $date);
    public function getByStatus(string $status);
    public function getMonthlySummary(int $employeeId, int $year, int $month);
    public function getPendingApproval();
}
