<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    protected array $allowedFilters = ['title', 'status_id', 'owner_id', 'assigned_to'];
    protected array $allowedSorts   = ['id', 'title', 'created_at', 'updated_at'];

    public function __construct(protected Task $task)
    {
        parent::__construct($task);
    }

}
