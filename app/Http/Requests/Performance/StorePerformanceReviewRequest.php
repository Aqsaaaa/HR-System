<?php

namespace App\Http\Requests\Performance;

use Illuminate\Foundation\Http\FormRequest;

class StorePerformanceReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('performance.submit.review');
    }

    public function rules(): array
    {
        return [
            'cycle_id' => ['required', 'exists:performance_cycles,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'reviewer_id' => ['nullable', 'exists:employees,id'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'comments' => ['nullable', 'string'],
            'strengths' => ['nullable', 'string'],
            'improvements' => ['nullable', 'string'],
        ];
    }
}
