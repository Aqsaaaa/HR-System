<?php

namespace App\Http\Resources\Announcement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'is_pinned' => $this->is_pinned,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at,
            'created_by_name' => $this->createdBy?->name,
            'created_at' => $this->created_at,
        ];
    }
}
