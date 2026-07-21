<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'employee_id', 'user_name', 'user_email',
        'event', 'module', 'action',
        'subject_type', 'subject_id', 'subject_description',
        'old_values', 'new_values', 'changes',
        'ip_address', 'user_agent', 'request_id', 'url', 'method',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
