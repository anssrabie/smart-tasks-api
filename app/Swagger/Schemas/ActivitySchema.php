<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     schema="Activity",
 *     type="object",
 *     title="Activity Log",
 *     description="Activity log entry",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="event", type="string", example="updated"),
 *     @OA\Property(property="description", type="string", example="Task status changed from Pending to Completed"),
 *     @OA\Property(property="causer", ref="#/components/schemas/User"),
 *     @OA\Property(property="properties", type="object", example={"old": {"status": "Pending"}, "new": {"status": "Completed"}}),
 *     @OA\Property(property="created_at", type="string", example="24-Aug-2025 21:05")
 * )
 */
class ActivitySchema
{
}
