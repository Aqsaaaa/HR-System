<?php

namespace App\Services\Performance;

use App\Models\PerformanceCycle;
use App\Repositories\Contracts\PerformanceCycleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PerformanceCycleService
{
    public function __construct(
        private PerformanceCycleRepositoryInterface $repository
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate(20, $filters);
    }

    public function find(int $id): PerformanceCycle
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): PerformanceCycle
    {
        $data['created_by'] = auth()->id();
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): PerformanceCycle
    {
        $cycle = $this->repository->findOrFail($id);
        return $this->repository->update($cycle, $data);
    }

    public function delete(int $id): bool
    {
        $cycle = $this->repository->findOrFail($id);
        return $this->repository->delete($cycle);
    }

    public function launch(int $id): PerformanceCycle
    {
        $cycle = $this->repository->findOrFail($id);
        return $this->repository->update($cycle, ['status' => 'active']);
    }
}
