<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface extends RepositoryInterface
{
    public function findByUserId(int $userId);
    public function findByDepartment(int $departmentId);
    public function findByPosition(int $positionId);
    public function getActive();
    public function getByStatus(string $status);
    public function search(string $query);
    public function getBySupervisor(int $supervisorId): Collection;
}
