<?php

namespace App\Services\Announcement;

use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AnnouncementService
{
    public function __construct(
        private AnnouncementRepositoryInterface $repository
    ) {}

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate(20, $filters);
    }

    public function find(int $id): Announcement
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Announcement
    {
        $data['created_by'] = auth()->id();
        if (isset($data['is_published']) && $data['is_published']) {
            $data['published_at'] = now();
        }
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Announcement
    {
        $announcement = $this->repository->findOrFail($id);
        if (isset($data['is_published']) && $data['is_published'] && !$announcement->published_at) {
            $data['published_at'] = now();
        }
        return $this->repository->update($announcement, $data);
    }

    public function delete(int $id): bool
    {
        $announcement = $this->repository->findOrFail($id);
        return $this->repository->delete($announcement);
    }

    public function togglePin(int $id): Announcement
    {
        $announcement = $this->repository->findOrFail($id);
        return $this->repository->update($announcement, ['is_pinned' => !$announcement->is_pinned]);
    }

    public function markAsRead(int $id): void
    {
        // could log to a reads table; for now no-op
    }
}
