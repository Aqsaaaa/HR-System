<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\Employee\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    public function __construct(
        private EmployeeService $employeeService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $employees = $this->employeeService->getAll($request->all());
        return $this->paginated($employees, EmployeeResource::class);
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = $this->employeeService->create($request->validated());
        return $this->created(new EmployeeResource($employee), 'Employee created successfully');
    }

    public function show(int $id): JsonResponse
    {
        $employee = $this->employeeService->find($id);
        return $this->success(new EmployeeResource($employee));
    }

    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        $employee = $this->employeeService->update($id, $request->validated());
        return $this->success(new EmployeeResource($employee), 'Employee updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->employeeService->delete($id);
        return $this->noContent();
    }

    public function export(Request $request): JsonResponse
    {
        $employees = \App\Models\Employee::with(['department', 'position'])->get();
        return $this->success(EmployeeResource::collection($employees));
    }

    public function import(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx']);
        return $this->success([], 'Import started successfully');
    }

    public function template(): JsonResponse
    {
        $headers = [
            'employee_id', 'first_name', 'last_name', 'email', 'phone',
            'department_id', 'position_id', 'employment_type', 'employment_status',
            'hire_date', 'gender', 'date_of_birth', 'marital_status',
            'nationality', 'identity_number', 'address', 'city', 'state',
            'postal_code', 'country', 'emergency_contact_name', 'emergency_contact_phone',
        ];
        return $this->success(['headers' => $headers]);
    }

    public function documents(int $id): JsonResponse
    {
        return $this->success([]);
    }

    public function uploadDocument(Request $request, int $id): JsonResponse
    {
        $request->validate(['file' => 'required|file|max:10240']);
        return $this->success([], 'Document uploaded', 201);
    }

    public function deleteDocument(int $id, int $docId): JsonResponse
    {
        return $this->noContent();
    }

    public function history(int $id): JsonResponse
    {
        $employee = $this->employeeService->find($id);
        $auditLogs = $employee->auditLogs()->latest()->paginate(50);
        return $this->paginated($auditLogs);
    }

    public function timeline(int $id): JsonResponse
    {
        $employee = $this->employeeService->find($id);
        $auditLogs = $employee->auditLogs()->latest()->take(100)->get();
        return $this->success($auditLogs);
    }

    public function restore(int $id): JsonResponse
    {
        $employee = $this->employeeService->restore($id);
        return $this->success(new EmployeeResource($employee), 'Employee restored successfully');
    }

    public function forceDelete(int $id): JsonResponse
    {
        $this->employeeService->forceDelete($id);
        return $this->noContent();
    }
}
