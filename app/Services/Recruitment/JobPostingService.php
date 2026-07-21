<?php

namespace App\Services\Recruitment;

use App\Models\JobPosting;
use App\Repositories\Contracts\JobPostingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class JobPostingService
{
    public function __construct(
        private JobPostingRepositoryInterface $repository
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate(20, $filters);
    }

    public function find(int $id): JobPosting
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): JobPosting
    {
        $data['created_by'] = auth()->id();
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): JobPosting
    {
        $job = $this->repository->findOrFail($id);
        return $this->repository->update($job, $data);
    }

    public function delete(int $id): bool
    {
        $job = $this->repository->findOrFail($id);
        return $this->repository->delete($job);
    }

    public function getPublished(): LengthAwarePaginator
    {
        return $this->repository->getPublished();
    }

    public function getPipeline(): array
    {
        return $this->repository->getPipeline();
    }
}
