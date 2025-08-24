<?php

namespace App\Swagger\Controllers;

use OpenApi\Annotations as OA;

class TaskControllerDocs
{
    /**
     * @OA\Get(
     *     path="/api/v1/tasks",
     *     summary="Get all tasks (paginated)",
     *     tags={"Tasks"},
     *     security={{"sanctum":{}},{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="filter[title]",
     *         in="query",
     *         description="Filter tasks by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="filter[status_id]",
     *         in="query",
     *         description="Filter tasks by status id",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="filter[owner_id]",
     *         in="query",
     *         description="Filter tasks by owner id",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="filter[assigned_to]",
     *         in="query",
     *         description="Filter tasks by assigned user id",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Sort by field (prefix with - for descending). Allowed: id, title, created_at, updated_at",
     *         required=false,
     *         @OA\Schema(type="string", example="-id")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedTasks")
     *     )
     * )
     */
    public function index() {}
    /**
     * @OA\Post(
     *     path="/api/v1/tasks",
     *     summary="Create a new task",
     *     security={
     *         {"sanctum":{}},
     *         {"ApiKeyAuth":{}}
     *     },
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store() {}

    /**
     * @OA\Get(
     *     path="/api/v1/tasks/{id}",
     *     summary="Get a single task by ID",
     *     security={
     *         {"sanctum":{}},
     *         {"ApiKeyAuth":{}}
     *     },
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function show() {}

    /**
     * @OA\Patch(
     *     path="/api/v1/tasks/{id}",
     *     summary="Update an existing task",
     *     security={
     *         {"sanctum":{}},
     *         {"ApiKeyAuth":{}}
     *     },
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/v1/tasks/{id}",
     *     summary="Delete a task by ID",
     *     security={
     *         {"sanctum":{}},
     *         {"ApiKeyAuth":{}}
     *     },
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Task deleted successfully"),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function destroy() {}


    /**
     * @OA\Patch(
     *     path="/api/v1/tasks/{id}/assign",
     *     summary="Assign task to a user",
     *     tags={"Tasks"},
     *     security={{"sanctum":{}},{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="assigned_to", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task assigned successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Task not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function assign() {}

    /**
     * @OA\Patch(
     *     path="/api/v1/tasks/{id}/status",
     *     summary="Update task status",
     *     tags={"Tasks"},
     *     security={{"sanctum":{}},{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task status updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=404, description="Task not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function updateStatus() {}
}
