<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Leave\ApproveLeaveRequest;
use App\Http\Requests\Leave\StoreLeaveRequest;
use App\Http\Resources\Leave\LeaveRequestResource;
use App\Models\Employee;
use App\Services\Leave\LeaveRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveRequestController extends BaseController
{
    public function __construct(
        private LeaveRequestService $leaveRequestService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();

        if ($request->has('all') && $user->can('leave-request.view-all')) {
            $leaveRequests = $this->leaveRequestService->getAll($request->all());
        } else {
            $leaveRequests = $this->leaveRequestService->getByEmployee(
                $employee->id,
                $request->all()
            );
        }

        return $this->paginated($leaveRequests, LeaveRequestResource::class);
    }

    public function store(StoreLeaveRequest $request): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $data = $request->validated();
        $data['employee_id'] = $employee->id;

        $leaveRequest = $this->leaveRequestService->create($data);
        return $this->created(new LeaveRequestResource($leaveRequest), 'Leave request submitted');
    }

    public function show(int $id): JsonResponse
    {
        $leaveRequest = $this->leaveRequestService->find($id);
        return $this->success(new LeaveRequestResource($leaveRequest));
    }

    public function destroy(int $id): JsonResponse
    {
        $leaveRequest = $this->leaveRequestService->cancel($id);
        return $this->success(new LeaveRequestResource($leaveRequest), 'Leave request cancelled');
    }

    public function approve(ApproveLeaveRequest $request, int $id): JsonResponse
    {
        $leaveRequest = $this->leaveRequestService->approve($id, $request->validated());
        return $this->success(new LeaveRequestResource($leaveRequest), 'Leave request approved');
    }

    public function reject(ApproveLeaveRequest $request, int $id): JsonResponse
    {
        $leaveRequest = $this->leaveRequestService->reject($id, $request->validated());
        return $this->success(new LeaveRequestResource($leaveRequest), 'Leave request rejected');
    }

    public function balances(): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $balances = $this->leaveRequestService->getBalances($employee->id);
        return $this->success($balances);
    }

    public function employeeBalances(int $employeeId): JsonResponse
    {
        $balances = $this->leaveRequestService->getEmployeeBalances($employeeId);
        return $this->success($balances);
    }

    public function calendar(Request $request): JsonResponse
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month');
        $calendar = $this->leaveRequestService->getCalendar((int) $year, $month ? (int) $month : null);
        return $this->success($calendar);
    }

    public function report(Request $request): JsonResponse
    {
        $report = $this->leaveRequestService->getReport($request->all());
        return $this->paginated($report, LeaveRequestResource::class);
    }
}
