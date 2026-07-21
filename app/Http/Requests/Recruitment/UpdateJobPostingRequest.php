<?php

namespace App\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobPostingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('recruitment.update.job');
    }

    public function rules(): array
    {
        return [
            'position_id' => ['sometimes', 'required', 'exists:positions,id'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'requirements' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'location' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'in:full_time,part_time,contract,internship'],
            'status' => ['nullable', 'string', 'in:draft,published,closed'],
            'slots' => ['nullable', 'integer', 'min:1'],
            'posted_at' => ['nullable', 'date'],
            'closed_at' => ['nullable', 'date', 'after_or_equal:posted_at'],
        ];
    }
}
