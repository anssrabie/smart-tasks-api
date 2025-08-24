<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tasks\AssignTaskRequest;
use App\Http\Requests\Api\V1\Tasks\TaskRequest;
use App\Http\Requests\Api\V1\Tasks\UpdateTaskStatusRequest;
use App\Http\Resources\V1\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service){}

    public function index()
    {
        $tasks = $this->service->getData(
            relations: ['status','owner','assignedTo'],
            usePagination: true
        );
        return $this->returnData(TaskResource::collection($tasks)->response()->getData(true),'Tasks retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = $this->service->storeResource($request->validated());
        return $this->returnData(new TaskResource($task),'Task created successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = $this->service->showResource($id);
        return $this->returnData(new TaskResource($task),'Task retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)
    {
        $task = $this->service->updateResource($id,$request->validated());
        return $this->returnData(new TaskResource($task),'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->deleteResource($id);
        return $this->successMessage('Task deleted successfully');
    }

    /**
     * Update assigned_to of specified resource in storage.
     */
    public function assign(AssignTaskRequest $request, string $id)
    {
        $task = $this->service->updateResource($id, $request->validated());
        return $this->returnData(new TaskResource($task), 'Task assigned successfully');
    }

    /**
     * Update status the specified resource in storage.
     */
    public function updateStatus(UpdateTaskStatusRequest $request, string $id)
    {
        $task = $this->service->updateResource($id, $request->validated());
        return $this->returnData(new TaskResource($task), 'Task status updated successfully');
    }
}
