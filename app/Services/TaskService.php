<?php

namespace App\Services;

use App\Constants\CacheKeys;
use App\Models\Status;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TaskService extends BaseService
{
    protected array $defaultRelations = ['status','owner','assignedTo','activities'];
    public function __construct(protected TaskRepositoryInterface $taskRepository)
    {
        parent::__construct($taskRepository);
    }

    public function storeResource(array $data, array $relations = []): Model
    {
        if (empty($data['status_id'])) {
            $data['status_id'] = Status::first()->id;
        }
        return parent::storeResource($data);
    }

    public function showResource($id, array $relations = [], array $scopes = []): Model
    {
        $cacheKey = CacheKeys::make(CacheKeys::TASK, ['id' => $id]);
        return Cache::remember($cacheKey, now()->addMinutes(10), function() use ($id, $relations, $scopes) {
            return parent::showResource($id, $relations, $scopes);
        });
    }
}
