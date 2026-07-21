<?php

namespace App\Http\Resources\Payroll;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollRunResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'period_type' => $this->period_type,
            'month' => $this->month,
            'year' => $this->year,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'payment_date' => $this->payment_date,
            'status' => $this->status,
            'total_gross' => $this->total_gross,
            'total_deductions' => $this->total_deductions,
            'total_net' => $this->total_net,
            'total_employees' => $this->total_employees,
            'processed_at' => $this->processed_at,
            'completed_at' => $this->completed_at,
            'notes' => $this->notes,
            'payslips' => PayslipResource::collection($this->whenLoaded('payslips')),
            'created_at' => $this->created_at,
        ];
    }
}
