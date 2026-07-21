<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::latest();

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('event', 'like', "%{$search}%")
                  ->orWhere('subject_description', 'like', "%{$search}%");
            });
        }

        $modules = AuditLog::distinct('module')->pluck('module')->sort()->values();
        $actions = AuditLog::distinct('action')->pluck('action')->sort()->values();

        return Inertia::render('Audit/Log', [
            'logs' => $query->paginate(20)->withQueryString(),
            'modules' => $modules,
            'actions' => $actions,
            'filters' => $request->only(['module', 'action', 'search']),
        ]);
    }
}
