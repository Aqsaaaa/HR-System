<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface JobPostingRepositoryInterface extends RepositoryInterface
{
    public function getPublished(): LengthAwarePaginator;

    public function getPipeline(): array;
}
