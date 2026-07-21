<?php

namespace App\Repositories;

use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AnnouncementRepository extends BaseRepository implements AnnouncementRepositoryInterface
{
    public function __construct(Announcement $model)
    {
        parent::__construct($model);
    }

    public function getPublished(): LengthAwarePaginator
    {
        return $this->model->where('is_published', true)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->paginate(20);
    }
}
