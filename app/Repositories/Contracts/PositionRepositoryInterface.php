<?php

namespace App\Repositories\Contracts;

interface PositionRepositoryInterface extends RepositoryInterface
{
    public function getByDepartment(int $departmentId, int $perPage = 15);
    public function getVacant();
}
