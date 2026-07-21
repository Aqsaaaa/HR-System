<?php

namespace App\Http\Requests\Announcement;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('announcement.create');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['nullable', 'string', 'in:info,warning,urgent,achievement'],
            'is_pinned' => ['boolean'],
            'is_published' => ['boolean'],
        ];
    }
}
