<?php

namespace App\Repositories\Contracts;

interface LeaveTypeRepositoryInterface extends RepositoryInterface
{
    public function getActive();
    public function findByCode(string $code);
}
