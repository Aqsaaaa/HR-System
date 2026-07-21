<?php

namespace App\Services\Performance;

use App\Models\PerformanceReview;
use App\Repositories\Contracts\PerformanceReviewRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PerformanceReviewService
{
    public function __construct(
        private PerformanceReviewRepositoryInterface $repository
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate(20, $filters);
    }

    public function find(int $id): PerformanceReview
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): PerformanceReview
    {
        $data['created_by'] = auth()->id();
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): PerformanceReview
    {
        $review = $this->repository->findOrFail($id);
        return $this->repository->update($review, $data);
    }

    public function delete(int $id): bool
    {
        $review = $this->repository->findOrFail($id);
        return $this->repository->delete($review);
    }

    public function submit(int $id): PerformanceReview
    {
        $review = $this->repository->findOrFail($id);
        return $this->repository->update($review, [
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }
}
