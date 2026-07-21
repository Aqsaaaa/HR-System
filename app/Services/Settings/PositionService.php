<?php

namespace App\Services\Settings;

use App\Models\Position;
use App\Repositories\Contracts\PositionRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Support\Facades\DB;

class PositionService
{
    public function __construct(
        private PositionRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function find(int $id): Position
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Position
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $position = $this->repository->create($data);
            $this->auditService->logCreate($position, $data, 'position');
            return $position;
        });
    }

    public function update(int $id, array $data): Position
    {
        return DB::transaction(function () use ($id, $data) {
            $position = $this->repository->findOrFail($id);
            $old = $position->toArray();
            $position = $this->repository->update($position, $data);
            $this->auditService->logUpdate($position, $old, $data, 'position');
            return $position;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $position = $this->repository->findOrFail($id);

            if ($position->employees()->count() > 0) {
                throw new \App\Exceptions\BusinessRuleException(
                    'Cannot delete position with active employees.'
                );
            }

            $this->repository->delete($position);
            $this->auditService->logDelete($position, 'position');
        });
    }

    public function getVacant()
    {
        return $this->repository->getVacant();
    }
}
