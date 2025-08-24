<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\{Builder, Collection, Model, ModelNotFoundException};
use Closure;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseRepository implements BaseRepositoryInterface
{
    protected array $relations = [];
    protected array $scopes = [];
    protected array $allowedFilters = [];
    protected array $allowedSorts = [];
    protected array $sorts = [];
    protected array $withCount = [];
    protected array $columns = ['*'];
    protected ?string $orderBy = null;
    protected string $orderDirection = 'asc';

    protected $modelClass;
    public function __construct(public $model)
    {
        $this->modelClass = get_class($this->model);
    }

    public function query(): QueryBuilder
    {
        $query = QueryBuilder::for($this->modelClass)
            ->select($this->columns)
            ->scopes($this->scopes)
            ->with($this->relations)
            ->withCount($this->withCount);

        if (!empty($this->allowedFilters)) {
            $query->allowedFilters($this->allowedFilters);
        }

        if (!empty($this->allowedSorts)) {
            $query->allowedSorts($this->allowedSorts);
        }

        if ($this->orderBy) {
            $query->orderBy($this->orderBy, $this->orderDirection);
        }
        return $query;
    }


    public function withRelations($relations): static
    {
        $this->relations = $relations;
        return $this;
    }

    public function withScopes(array $scopes): static
    {
        $this->scopes = $scopes;
        return $this;
    }

    public function withCount(array $counts): static
    {
        $this->withCount = $counts;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'desc'): static
    {
        $this->orderBy = $column;
        $this->orderDirection = $direction;
        return $this;
    }

    public function all(): Collection
    {
        return $this->query()->get();
    }

    public function select(array $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    public function paginate($perPage = 10): CursorPaginator
    {
        return $this->query()->cursorPaginate($perPage);
    }

    public function filter(array $filters): static
    {
        $this->filters = $filters;
        return $this;
    }

    public function sort(array $sorts): static
    {
        $this->sorts = $sorts;
        return $this;
    }

    public function create(array $data, array $relations = []): Model
    {
        $modelObject = $this->model->create($data);
        if (!empty($relations)) {
            $modelObject->load($relations);
        }
        return $modelObject;
    }

    public function find(int|string $id, ?string $errorMessage = null): Model
    {
        try {
            return $this->query()->findOrFail($id);
        } catch (\Exception $e) {
            $modelName = class_basename($this->model);
            throw new NotFoundHttpException($errorMessage ?? "{$modelName} Not Found.");
        }
    }

    public function update(array $data, $id, array $relations = []): Model
    {
        $modelObject = $this->find($id);
        $modelObject->update($data);
        $modelObject->refresh();
        if (!empty($relations)) {
            $modelObject->load($relations);
        }
        return $modelObject;
    }
    public function getBy(array $conditions): Collection
    {
        return $this->query()->where($conditions)->get();
    }

    public function findBy(array $conditions,?string $errorMessage = null): Model
    {
        try {
            return $this->query()->where($conditions)->firstOrFail();
        } catch (\Exception $e) {
            $modelName = class_basename($this->model);
            $errorMessage = $errorMessage ?? "No matching {$modelName} found with the provided conditions.";
            throw new NotFoundHttpException($errorMessage);
        }
    }

    public function firstBy(array $conditions, ?string $orderByColumn = null, string $direction = 'desc'): Model
    {
        $query = $this->query()->where($conditions);
        if ($orderByColumn) {
            $query = $query->orderBy($orderByColumn, $direction);
        }
        return $query->first();
    }

    public function firstWhere(array $conditions)
    {
        return $this->query()->firstWhere($conditions);
    }

    public function allWhere(array $conditions): Collection
    {
        return $this->query()->where($conditions)->get();
    }

    public function whereIn(string $column, array $values): QueryBuilder
    {
        return $this->query()->whereIn($column, $values);
    }

    public function whereNotIn(string $column, array $values): QueryBuilder
    {
        return $this->query()->whereNotIn($column, $values);
    }

    public function whereHas(string $relation, Closure $callback): QueryBuilder
    {
        return $this->query()->whereHas($relation, $callback);
    }

    public function updateOrCreate(array $conditions, array $data)
    {
        return $this->query()->updateOrCreate($conditions, $data);
    }

    public function firstOrCreate(array $data,array $conditions = [])
    {
        return $this->query()->firstOrCreate($conditions, $data);
    }

    public function exists(array $conditions): bool
    {
        return $this->query()->where($conditions)->exists();
    }

    public function delete($id): bool
    {
        return $this->find($id)->delete();
    }

    public function deleteBy(array $conditions): mixed
    {
        return $this->query()->where($conditions)->delete();
    }

    public function destroy(array $ids)
    {
        return $this->model->destroy($ids);
    }

    public function bulkInsert(array $records)
    {
       return $this->model->insert($records);
    }
}
