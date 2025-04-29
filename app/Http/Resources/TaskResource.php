<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'due_date'     => $this->due_date ? $this->due_date->format('Y-m-d') : null,
            'priority'     => $this->priority,
            'is_completed' => $this->is_completed,
        ];
    }
}
