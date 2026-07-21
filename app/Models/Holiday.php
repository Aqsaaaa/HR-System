<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'name', 'date', 'type', 'year', 'is_recurring',
        'description', 'is_active', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_recurring' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected array $sortable = ['date', 'name', 'type', 'created_at'];
}
