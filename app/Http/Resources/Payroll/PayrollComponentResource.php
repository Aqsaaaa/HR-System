<?php

namespace App\Http\Resources\Payroll;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollComponentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'calculation_type' => $this->calculation_type,
            'default_value' => $this->default_value,
            'frequency' => $this->frequency,
            'is_taxable' => $this->is_taxable,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'description' => $this->description,
        ];
    }
}
