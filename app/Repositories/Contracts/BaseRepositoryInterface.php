<?php

namespace App\Repositories\Contracts;

use Closure;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface BaseRepositoryInterface
{
    public function query(): QueryBuilder;

    public function withRelations(array $relations): static;

    public function withScopes(array $scopes): static;

    public function withCount(array $counts): static;

    public function orderBy(string $column, string $direction = 'desc'): static;

    public function select(array $columns): static;

    public function all(): Collection;

    public function paginate(int $perPage = 10): CursorPaginator;

    public function filter(array $filters): static;

    public function sort(array $sorts): static;

    public function create(array $data, array $relations = []): Model;

    public function find(int|string $id, ?string $errorMessage = null): Model;

    public function update(array $data, $id): Model;

    public function delete($id): bool;

    public function getBy(array $conditions): Collection;

    public function findBy(array $conditions, ?string $errorMessage = null): ?Model;

    public function firstBy(array $conditions, ?string $orderByColumn = null, string $direction = 'desc'): ?Model;

    public function whereHas(string $relation, Closure $callback): QueryBuilder;

    public function firstOrCreate(array $data, array $conditions = []);
}
