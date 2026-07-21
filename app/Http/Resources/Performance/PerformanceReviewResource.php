<?php

namespace App\Http\Resources\Performance;

use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerformanceReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cycle' => new PerformanceCycleResource($this->whenLoaded('cycle')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'reviewer' => new EmployeeResource($this->whenLoaded('reviewer')),
            'rating' => $this->rating,
            'comments' => $this->comments,
            'strengths' => $this->strengths,
            'improvements' => $this->improvements,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
        ];
    }
}
