<?php

namespace App\Services\Payroll;

use App\Models\PayrollComponent;
use App\Repositories\Contracts\PayrollComponentRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Support\Facades\DB;

class PayrollComponentService
{
    public function __construct(
        private PayrollComponentRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function getActive()
    {
        return $this->repository->getActive();
    }

    public function find(int $id): PayrollComponent
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): PayrollComponent
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $component = $this->repository->create($data);
            $this->auditService->logCreate($component, $data, 'payroll_component');
            return $component;
        });
    }

    public function update(int $id, array $data): PayrollComponent
    {
        return DB::transaction(function () use ($id, $data) {
            $component = $this->repository->findOrFail($id);
            $old = $component->toArray();
            $component = $this->repository->update($component, $data);
            $this->auditService->logUpdate($component, $old, $data, 'payroll_component');
            return $component;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $component = $this->repository->findOrFail($id);
            $this->repository->delete($component);
            $this->auditService->logDelete($component, 'payroll_component');
        });
    }
}
