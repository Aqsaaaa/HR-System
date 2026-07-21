<?php

namespace App\Http\Requests\Announcement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('announcement.update');
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
            'type' => ['nullable', 'string', 'in:info,warning,urgent,achievement'],
            'is_pinned' => ['boolean'],
            'is_published' => ['boolean'],
        ];
    }
}
