<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'type' => $this->type,
            'year' => $this->year,
            'is_recurring' => $this->is_recurring,
            'description' => $this->description,
        ];
    }
}
