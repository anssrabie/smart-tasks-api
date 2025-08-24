<?php

namespace App\Services;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseService
{
    protected array $defaultRelations = [];
    public function __construct(public BaseRepositoryInterface  $repository)
    {
    }

    public function getData(
        array $relations = [],
        bool $usePagination = false,
        int $perPage = 30,
        array $scopes = [],
        array $columns = ['*'],
        ?string $orderBy = null,
        ?string $orderDirection = null,
    )
    {
        $query = $this->repository
            ->withRelations($relations ?: $this->defaultRelations)
            ->withScopes($scopes)
            ->select($columns);

        if ($orderBy && $orderDirection) {
            $query->orderBy($orderBy, $orderDirection);
        }
        return $usePagination ? $query->paginate($perPage) : $query->all();
    }


    public function storeResource(array $data, array $relations = []): Model
    {
        return $this->repository->create($data,$relations ?: $this->defaultRelations);
    }

    public function showResource($id, array $relations = [],array $scopes = []): Model
    {
        return $this->repository->withRelations($relations ?: $this->defaultRelations)->withScopes($scopes)->find($id);
    }

    public function updateResource($id, $data, array $relations = []): Model
    {
        return $this->repository->update($data, $id, $relations ?: $this->defaultRelations);
    }

    public function deleteResource($id): void
    {
         $this->repository->delete($id);
    }

    public function getBy(array $conditions): Collection
    {
        return $this->repository->getBy($conditions);
    }

    public function findBy(array $conditions, ?string $errorMessage = null){
        return $this->repository->findBy($conditions,$errorMessage);
    }

    public function first(string $value, string $operator = '=' ,string $columnName = 'id',array $relations = [],array $scopes = []){
        return $this->repository->withRelations($relations)->withScopes($scopes)->firstBy([[$columnName,$operator,$value]]);
    }

    public function firstBy(array $conditions, ?string $orderByColumn = null, string $direction = 'desc'){
        return $this->repository->firstBy($conditions,$orderByColumn,$direction);
    }

    public function whereHas(string $relation, Closure $callback): QueryBuilder
    {
        return $this->repository->whereHas($relation, $callback);
    }

    public function firstOrCreate(array $data,array $conditions = []){
        return $this->repository->firstOrCreate($data, $conditions);
    }
}
