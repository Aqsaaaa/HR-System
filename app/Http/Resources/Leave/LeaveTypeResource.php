<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'days_per_year' => $this->days_per_year,
            'max_consecutive_days' => $this->max_consecutive_days,
            'min_days_before' => $this->min_days_before,
            'requires_attachment' => $this->requires_attachment,
            'is_paid' => $this->is_paid,
            'is_active' => $this->is_active,
            'color' => $this->color,
        ];
    }
}
