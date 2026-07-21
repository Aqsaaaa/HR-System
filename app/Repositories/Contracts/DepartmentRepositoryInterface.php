<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface extends RepositoryInterface
{
    public function getTree(): Collection;
    public function getRootDepartments(): Collection;
    public function getByManager(int $managerId): Collection;
}
