<?php

namespace App\Http\Resources\Recruitment;

use App\Http\Resources\PositionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'responsibilities' => $this->responsibilities,
            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'location' => $this->location,
            'type' => $this->type,
            'status' => $this->status,
            'slots' => $this->slots,
            'posted_at' => $this->posted_at,
            'closed_at' => $this->closed_at,
            'position' => new PositionResource($this->whenLoaded('position')),
            'applications_count' => $this->whenCounted('applications'),
            'created_at' => $this->created_at,
        ];
    }
}
