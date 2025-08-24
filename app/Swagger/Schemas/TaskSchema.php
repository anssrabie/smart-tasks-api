<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     title="Task",
 *     description="Task model",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Title"),
 *     @OA\Property(property="description", type="string", example="Long description of the task"),
 *
 *     @OA\Property(
 *         property="status",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer", example=2),
 *         @OA\Property(property="name", type="string", example="Pending")
 *     ),
 *
 *     @OA\Property(property="owner", ref="#/components/schemas/User"),
 *     @OA\Property(property="assigned_to", ref="#/components/schemas/User"),
 *
 *     @OA\Property(
 *         property="logs",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Activity")
 *     ),
 *
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         example="24-Aug-2025 21:05"
 *     ),
 *
 *     @OA\Property(
 *         property="last_updated_at",
 *         type="string",
 *         example="2 hours ago"
 *     )
 * )
 */
class TaskSchema {}
