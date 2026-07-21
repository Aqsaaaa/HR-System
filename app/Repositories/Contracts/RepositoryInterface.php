<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(array $columns = ['*']): Collection;
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
    public function find(int $id): ?Model;
    public function findOrFail(int $id): Model;
    public function findBy(string $field, mixed $value): ?Model;
    public function create(array $data): Model;
    public function update(Model $model, array $data): Model;
    public function delete(Model $model): bool;
    public function restore(int $id): bool;
    public function forceDelete(int $id): bool;
    public function count(): int;
    public function exists(array $conditions): bool;
}
