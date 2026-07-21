<?php

namespace App\Http\Resources\Recruitment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'resume_path' => $this->resume_path,
            'portfolio_url' => $this->portfolio_url,
            'source' => $this->source,
            'status' => $this->status,
            'notes' => $this->notes,
            'applications' => JobApplicationResource::collection($this->whenLoaded('applications')),
            'created_at' => $this->created_at,
        ];
    }
}
