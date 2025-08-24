<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

class PaginationSchemas
{
    /**
     * @OA\Schema(
     *     schema="PaginatedTasks",
     *     type="object",
     *     @OA\Property(property="status", type="boolean", example=true),
     *     @OA\Property(property="message", type="string", example="Tasks retrieved successfully"),
     *     @OA\Property(property="code", type="integer", example=200),
     *     @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Property(
     *         property="meta",
     *         type="object",
     *         @OA\Property(property="current_page", type="integer", example=1),
     *         @OA\Property(property="from", type="integer", example=1),
     *         @OA\Property(property="last_page", type="integer", example=10),
     *         @OA\Property(property="per_page", type="integer", example=15),
     *         @OA\Property(property="to", type="integer", example=15),
     *         @OA\Property(property="total", type="integer", example=150)
     *     ),
     *     @OA\Property(
     *         property="links",
     *         type="object",
     *         @OA\Property(property="first", type="string", example="http://your-app.test/api/v1/tasks?page=1"),
     *         @OA\Property(property="last", type="string", example="http://your-app.test/api/v1/tasks?page=10"),
     *         @OA\Property(property="prev", type="string", nullable=true, example=null),
     *         @OA\Property(property="next", type="string", example="http://your-app.test/api/v1/tasks?page=2")
     *     )
     * )
     */
    public function schema() {}
}
