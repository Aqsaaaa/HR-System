<?php

namespace App\Services\Audit;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public function log(
        string $event,
        string $module,
        string $action,
        ?Model $subject = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
    ): AuditLog {
        $user = auth()->user();

        return AuditLog::create([
            'user_id' => $user?->id,
            'employee_id' => $user?->employee?->id,
            'user_name' => $user?->name,
            'user_email' => $user?->email,
            'event' => $event,
            'module' => $module,
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'subject_description' => $description ?? ($subject ? "#{$subject->id}" : null),
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'changes' => $this->computeChanges($oldValues, $newValues),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'request_id' => Request::header('X-Request-ID'),
            'url' => Request::fullUrl(),
            'method' => Request::method(),
        ]);
    }

    public function logCreate(Model $subject, array $data, string $module, string $event = null): AuditLog
    {
        $event = $event ?? "{$module}.created";
        return $this->log($event, $module, 'create', $subject, null, $data);
    }

    public function logUpdate(Model $subject, array $oldValues, array $newValues, string $module, string $event = null): AuditLog
    {
        $event = $event ?? "{$module}.updated";
        return $this->log($event, $module, 'update', $subject, $oldValues, $newValues);
    }

    public function logDelete(Model $subject, string $module, string $event = null): AuditLog
    {
        $event = $event ?? "{$module}.deleted";
        return $this->log($event, $module, 'delete', $subject, $subject->toArray(), null);
    }

    private function computeChanges(?array $old, ?array $new): ?string
    {
        if (!$old || !$new) {
            return null;
        }

        $changes = [];
        foreach ($new as $key => $value) {
            if (array_key_exists($key, $old) && $old[$key] !== $value) {
                $changes[$key] = [
                    'old' => $old[$key],
                    'new' => $value,
                ];
            }
        }

        return empty($changes) ? null : json_encode($changes);
    }
}
