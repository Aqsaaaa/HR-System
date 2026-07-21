<?php

namespace App\Http\Resources\Performance;

use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'title' => $this->title,
            'description' => $this->description,
            'key_results' => $this->key_results,
            'weight' => $this->weight,
            'progress' => $this->progress,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
        ];
    }
}
