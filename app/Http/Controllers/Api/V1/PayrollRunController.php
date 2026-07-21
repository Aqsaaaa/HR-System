<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Payroll\StorePayrollRunRequest;
use App\Http\Resources\Payroll\PayrollRunResource;
use App\Http\Resources\Payroll\PayslipResource;
use App\Models\Employee;
use App\Services\Payroll\PayrollRunService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayrollRunController extends BaseController
{
    public function __construct(
        private PayrollRunService $payrollRunService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $runs = $this->payrollRunService->getAll($request->all());
        return $this->paginated($runs, PayrollRunResource::class);
    }

    public function store(StorePayrollRunRequest $request): JsonResponse
    {
        $run = $this->payrollRunService->create($request->validated());
        return $this->created(new PayrollRunResource($run), 'Payroll run created');
    }

    public function show(int $id): JsonResponse
    {
        $run = $this->payrollRunService->find($id);
        return $this->success(new PayrollRunResource($run));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $run = $this->payrollRunService->update($id, $request->all());
        return $this->success(new PayrollRunResource($run), 'Payroll run updated');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->payrollRunService->delete($id);
        return $this->noContent();
    }

    public function process(int $id): JsonResponse
    {
        $run = $this->payrollRunService->process($id);
        return $this->success(new PayrollRunResource($run), 'Payroll run processing started');
    }

    public function complete(int $id): JsonResponse
    {
        $run = $this->payrollRunService->complete($id);
        return $this->success(new PayrollRunResource($run), 'Payroll run completed');
    }

    public function cancel(int $id): JsonResponse
    {
        $run = $this->payrollRunService->cancel($id);
        return $this->success(new PayrollRunResource($run), 'Payroll run cancelled');
    }

    public function preview(int $id): JsonResponse
    {
        $data = $this->payrollRunService->preview($id);
        return $this->success($data);
    }

    public function payslips(int $id): JsonResponse
    {
        $payslips = $this->payrollRunService->getPayslips($id);
        return $this->success(PayslipResource::collection($payslips));
    }

    public function myPayslips(): JsonResponse
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $payslips = $this->payrollRunService->getMyPayslips($employee->id);
        return $this->paginated($payslips, PayslipResource::class);
    }

    public function payslipDetail(int $id): JsonResponse
    {
        $payslip = $this->payrollRunService->getPayslipDetail($id);
        return $this->success(new PayslipResource($payslip));
    }

    public function downloadPayslip(int $id): JsonResponse
    {
        $payslip = $this->payrollRunService->getPayslipDetail($id);
        return $this->success(new PayslipResource($payslip));
    }

    public function report(Request $request): JsonResponse
    {
        $report = $this->payrollRunService->getReport($request->all());
        return $this->paginated($report, PayrollRunResource::class);
    }

    public function createAdjustment(Request $request): JsonResponse
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:earning,deduction',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:500',
        ]);

        $adjustment = $this->payrollRunService->createAdjustment($request->all());
        return $this->created($adjustment, 'Adjustment created');
    }

    public function exportJournal(): JsonResponse
    {
        return $this->success([]);
    }
}
