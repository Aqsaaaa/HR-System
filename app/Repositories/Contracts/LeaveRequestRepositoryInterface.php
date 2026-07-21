<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface LeaveRequestRepositoryInterface extends RepositoryInterface
{
    public function findByEmployee(int $employeeId, array $filters = []): LengthAwarePaginator;
    public function getByStatus(string $status): Collection;
    public function getPending(): Collection;
    public function getByDateRange(string $start, string $end): Collection;
    public function getByEmployeeAndYear(int $employeeId, int $year): Collection;
    public function getCalendar(int $year, ?int $month = null): Collection;
}
