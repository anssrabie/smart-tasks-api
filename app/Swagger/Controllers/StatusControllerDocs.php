<?php

namespace App\Swagger\Controllers;

use OpenApi\Annotations as OA;

class StatusControllerDocs
{
    /**
     * @OA\Get(
     *     path="/api/v1/statuses",
     *     summary="Get all statuses",
     *     tags={"Status"},
     *     security={{"sanctum":{}},{"ApiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="value", type="string", example="Pending")
     *             )
     *         )
     *     )
     * )
     */
    public function index() {}

}
