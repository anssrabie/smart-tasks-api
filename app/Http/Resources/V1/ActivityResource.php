<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'event'       => $this->event,
            'description' => $this->description,
            'causer'      => new UserResource($this->whenLoaded('causer')),
            'properties'  => $this->properties,
            'created_at'  => showDate($this->created_at),
        ];
    }
}
