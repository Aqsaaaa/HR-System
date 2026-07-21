<?php

namespace App\Repositories\Contracts;

interface PayrollComponentRepositoryInterface extends RepositoryInterface
{
    public function getByType(string $type);
    public function getActive();
}
