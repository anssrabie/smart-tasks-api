<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->whenLoaded('status'),
            'owner' => new UserResource($this->whenLoaded('owner')),
            'assigned_to' => new UserResource($this->whenLoaded('assignedTo')),
            'logs' => ActivityResource::collection(
                $this->whenLoaded('activities', fn() => $this->activities->sortByDesc('created_at')) ?? collect()
            ),
            'created_at'  => showDate($this->created_at),
            'last_updated_at'  => showDate($this->updated_at,'human'),
        ];
    }
}
