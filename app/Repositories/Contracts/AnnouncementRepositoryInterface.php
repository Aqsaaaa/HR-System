<?php

namespace App\Repositories\Contracts;

interface AnnouncementRepositoryInterface extends RepositoryInterface
{
    public function getPublished();
}
