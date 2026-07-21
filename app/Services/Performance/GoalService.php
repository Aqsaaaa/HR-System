<?php

namespace App\Services\Performance;

use App\Models\Goal;
use App\Repositories\Contracts\GoalRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GoalService
{
    public function __construct(
        private GoalRepositoryInterface $repository
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate(20, $filters);
    }

    public function find(int $id): Goal
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Goal
    {
        $data['created_by'] = auth()->id();
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Goal
    {
        $goal = $this->repository->findOrFail($id);
        return $this->repository->update($goal, $data);
    }

    public function delete(int $id): bool
    {
        $goal = $this->repository->findOrFail($id);
        return $this->repository->delete($goal);
    }
}
