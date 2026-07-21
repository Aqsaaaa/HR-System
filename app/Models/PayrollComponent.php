<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollComponent extends Model
{
    use Filterable, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'type', 'calculation_type', 'default_value',
        'frequency', 'is_taxable', 'is_active', 'sort_order',
        'description', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'default_value' => 'decimal:2',
            'is_taxable' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected array $sortable = ['sort_order', 'name', 'type', 'created_at'];

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
