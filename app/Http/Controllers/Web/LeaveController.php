<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Services\Leave\LeaveRequestService;
use Inertia\Inertia;

class LeaveController extends Controller
{
    public function __construct(
        private LeaveRequestService $leaveRequestService
    ) {}

    public function create()
    {
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return Inertia::render('Leave/Create', [
            'leaveTypes' => $leaveTypes,
        ]);
    }

    public function index()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        $leaveRequests = $employee
            ? $this->leaveRequestService->getByEmployee($employee->id, request()->all())
            : [];
        $balances = $employee
            ? $this->leaveRequestService->getBalances($employee->id)
            : [];
        $leaveTypes = LeaveType::where('is_active', true)->get();

        return Inertia::render('Leave/Index', [
            'leaveRequests' => $leaveRequests,
            'balances' => $balances,
            'leaveTypes' => $leaveTypes,
            'filters' => request()->all(),
        ]);
    }
}
