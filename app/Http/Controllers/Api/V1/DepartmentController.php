<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Services\Settings\DepartmentService;
use Illuminate\Http\JsonResponse;

class DepartmentController extends BaseController
{
    public function __construct(
        private DepartmentService $departmentService,
    ) {}

    public function index(): JsonResponse
    {
        $departments = $this->departmentService->getAll(request()->all());
        return $this->paginated($departments);
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $department = $this->departmentService->create($request->validated());
        return $this->created(new DepartmentResource($department));
    }

    public function show(int $id): JsonResponse
    {
        $department = $this->departmentService->find($id);
        $department->load(['parent', 'children', 'manager', 'positions', 'employees']);
        return $this->success(new DepartmentResource($department));
    }

    public function update(UpdateDepartmentRequest $request, int $id): JsonResponse
    {
        $department = $this->departmentService->update($id, $request->validated());
        return $this->success(new DepartmentResource($department), 'Department updated.');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->departmentService->delete($id);
        return $this->noContent();
    }

    public function tree(): JsonResponse
    {
        $tree = $this->departmentService->getTree();
        return $this->success($tree);
    }
}
