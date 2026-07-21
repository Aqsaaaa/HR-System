<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Payroll\StorePayrollComponentRequest;
use App\Http\Requests\Payroll\UpdatePayrollComponentRequest;
use App\Http\Resources\Payroll\PayrollComponentResource;
use App\Services\Payroll\PayrollComponentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayrollComponentController extends BaseController
{
    public function __construct(
        private PayrollComponentService $componentService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $components = $this->componentService->getAll($request->all());
        return $this->paginated($components, PayrollComponentResource::class);
    }

    public function store(StorePayrollComponentRequest $request): JsonResponse
    {
        $component = $this->componentService->create($request->validated());
        return $this->created(new PayrollComponentResource($component), 'Component created');
    }

    public function show(int $id): JsonResponse
    {
        $component = $this->componentService->find($id);
        return $this->success(new PayrollComponentResource($component));
    }

    public function update(UpdatePayrollComponentRequest $request, int $id): JsonResponse
    {
        $component = $this->componentService->update($id, $request->validated());
        return $this->success(new PayrollComponentResource($component), 'Component updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->componentService->delete($id);
        return $this->noContent();
    }
}
