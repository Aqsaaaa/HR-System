<?php

namespace App\Services\Settings;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function __construct(
        private DepartmentRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function getTree(): Collection
    {
        return $this->repository->getTree();
    }

    public function find(int $id): Department
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Department
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $department = $this->repository->create($data);
            $this->auditService->logCreate($department, $data, 'department');
            return $department;
        });
    }

    public function update(int $id, array $data): Department
    {
        return DB::transaction(function () use ($id, $data) {
            $department = $this->repository->findOrFail($id);
            $old = $department->toArray();
            $department = $this->repository->update($department, $data);
            $this->auditService->logUpdate($department, $old, $data, 'department');
            return $department;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $department = $this->repository->findOrFail($id);

            if ($department->employees()->count() > 0) {
                throw new \App\Exceptions\BusinessRuleException(
                    'Cannot delete department with active employees.'
                );
            }

            $this->repository->delete($department);
            $this->auditService->logDelete($department, 'department');
        });
    }
}
