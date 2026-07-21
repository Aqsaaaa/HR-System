<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Leave\StoreLeaveTypeRequest;
use App\Http\Requests\Leave\UpdateLeaveTypeRequest;
use App\Http\Resources\Leave\LeaveTypeResource;
use App\Services\Leave\LeaveTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveTypeController extends BaseController
{
    public function __construct(
        private LeaveTypeService $leaveTypeService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $leaveTypes = $this->leaveTypeService->getAll($request->all());
        return $this->paginated($leaveTypes, LeaveTypeResource::class);
    }

    public function store(StoreLeaveTypeRequest $request): JsonResponse
    {
        $leaveType = $this->leaveTypeService->create($request->validated());
        return $this->created(new LeaveTypeResource($leaveType), 'Leave type created');
    }

    public function show(int $id): JsonResponse
    {
        $leaveType = $this->leaveTypeService->find($id);
        return $this->success(new LeaveTypeResource($leaveType));
    }

    public function update(UpdateLeaveTypeRequest $request, int $id): JsonResponse
    {
        $leaveType = $this->leaveTypeService->update($id, $request->validated());
        return $this->success(new LeaveTypeResource($leaveType), 'Leave type updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->leaveTypeService->delete($id);
        return $this->noContent();
    }
}
