<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TaskRequest",
 *     type="object",
 *     required={"title","description"},
 *     @OA\Property(property="title", type="string", example="New Task"),
 *     @OA\Property(property="description", type="string", example="Task description"),
 *     @OA\Property(property="status_id", type="integer", example=1, description="Optional status ID"),
 *     @OA\Property(property="assigned_to", type="integer", example=1, description="Optional assigned to ID"),
 * )
 */
class TaskRequestSchema {}
