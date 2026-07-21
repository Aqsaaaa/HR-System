<?php

namespace App\Http\Resources\Recruitment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job_posting' => new JobPostingResource($this->whenLoaded('jobPosting')),
            'candidate' => new CandidateResource($this->whenLoaded('candidate')),
            'stage' => $this->stage,
            'status' => $this->status,
            'notes' => $this->notes,
            'applied_at' => $this->applied_at,
            'created_at' => $this->created_at,
        ];
    }
}
