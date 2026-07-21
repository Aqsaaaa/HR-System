<?php

namespace App\Http\Requests\Performance;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerformanceCycleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('performance.create.cycle');
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['sometimes', 'required', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:draft,active,completed'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
