<?php

namespace App\Repositories;

use App\Models\JobPosting;
use App\Repositories\Contracts\JobPostingRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class JobPostingRepository extends BaseRepository implements JobPostingRepositoryInterface
{
    public function __construct(JobPosting $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->withCount('applications');

        if (!empty($filters)) {
            $this->applyFilters($query, $filters);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';

        return $query->orderBy($sort, $direction)
            ->paginate($filters['per_page'] ?? $perPage);
    }

    public function getPublished(): LengthAwarePaginator
    {
        return $this->model->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function getPipeline(): array
    {
        return $this->model->with(['applications.candidate', 'position'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }
}
