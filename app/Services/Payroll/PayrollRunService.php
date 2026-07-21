<?php

namespace App\Services\Payroll;

use App\Models\Employee;
use App\Models\PayrollComponent;
use App\Models\PayrollRun;
use App\Models\Payslip;
use App\Repositories\Contracts\PayrollRunRepositoryInterface;
use App\Services\Audit\AuditService;
use Illuminate\Support\Facades\DB;

class PayrollRunService
{
    public function __construct(
        private PayrollRunRepositoryInterface $repository,
        private AuditService $auditService,
    ) {}

    public function getAll(array $filters = [])
    {
        $filters['with'] = ['payslips'];
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    public function find(int $id): PayrollRun
    {
        return $this->repository->findOrFail($id)->load(['payslips.employee.user', 'payslips.employee.department']);
    }

    public function create(array $data): PayrollRun
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $run = $this->repository->create($data);
            $this->auditService->logCreate($run, $data, 'payroll_run');
            return $run;
        });
    }

    public function update(int $id, array $data): PayrollRun
    {
        return DB::transaction(function () use ($id, $data) {
            $run = $this->repository->findOrFail($id);
            $old = $run->toArray();
            $run = $this->repository->update($run, $data);
            $this->auditService->logUpdate($run, $old, $data, 'payroll_run');
            return $run;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $run = $this->repository->findOrFail($id);
            if ($run->status !== 'draft') {
                throw new \App\Exceptions\BusinessRuleException('Can only delete draft payroll runs.');
            }
            $this->repository->delete($run);
            $this->auditService->logDelete($run, 'payroll_run');
        });
    }

    public function process(int $id): PayrollRun
    {
        return DB::transaction(function () use ($id) {
            $run = $this->repository->findOrFail($id);

            if ($run->status !== 'draft') {
                throw new \App\Exceptions\BusinessRuleException('Payroll run must be in draft status to process.');
            }

            $this->repository->update($run, [
                'status' => 'processing',
                'processed_at' => now(),
                'processed_by' => auth()->id(),
            ]);

            $employees = Employee::where('employment_status', 'active')->get();
            $components = PayrollComponent::where('is_active', true)->orderBy('sort_order')->get();

            $totalGross = 0;
            $totalDeductions = 0;
            $employeeCount = 0;

            foreach ($employees as $employee) {
                $earnings = [];
                $deductions = [];
                $totalEarnings = 0;
                $totalDeductionsEmp = 0;

                foreach ($components as $component) {
                    $amount = $this->calculateComponent($component, $employee);
                    if ($component->type === 'earning') {
                        $earnings[] = ['name' => $component->name, 'code' => $component->code, 'amount' => $amount];
                        $totalEarnings += $amount;
                    } else {
                        $deductions[] = ['name' => $component->name, 'code' => $component->code, 'amount' => $amount];
                        $totalDeductionsEmp += $amount;
                    }
                }

                $basicSalary = $earnings[0]['amount'] ?? 0;
                $netPay = $totalEarnings - $totalDeductionsEmp;
                $employeeCount++;

                Payslip::create([
                    'payslip_no' => 'PSL-' . $run->id . '-' . str_pad((string) $employeeCount, 4, '0', STR_PAD_LEFT),
                    'payroll_run_id' => $run->id,
                    'employee_id' => $employee->id,
                    'basic_salary' => $basicSalary,
                    'earnings' => $earnings,
                    'deductions' => $deductions,
                    'total_earnings' => $totalEarnings,
                    'total_deductions' => $totalDeductionsEmp,
                    'net_pay' => max($netPay, 0),
                    'tax_amount' => 0,
                    'status' => 'draft',
                    'created_by' => auth()->id(),
                ]);

                $totalGross += $totalEarnings;
                $totalDeductions += $totalDeductionsEmp;
            }

            $run->update([
                'total_gross' => $totalGross,
                'total_deductions' => $totalDeductions,
                'total_net' => $totalGross - $totalDeductions,
                'total_employees' => $employeeCount,
            ]);

            $this->auditService->log('process', $run, [], 'payroll_run');
            return $run->fresh()->load('payslips');
        });
    }

    public function complete(int $id): PayrollRun
    {
        return DB::transaction(function () use ($id) {
            $run = $this->repository->findOrFail($id);

            if ($run->status !== 'processing') {
                throw new \App\Exceptions\BusinessRuleException('Payroll run must be in processing status to complete.');
            }

            $this->repository->update($run, [
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            Payslip::where('payroll_run_id', $run->id)
                ->update(['status' => 'paid', 'paid_at' => now()]);

            $this->auditService->log('complete', $run, [], 'payroll_run');
            return $run->fresh()->load('payslips');
        });
    }

    public function cancel(int $id): PayrollRun
    {
        return DB::transaction(function () use ($id) {
            $run = $this->repository->findOrFail($id);

            if (!in_array($run->status, ['draft', 'processing'])) {
                throw new \App\Exceptions\BusinessRuleException('Cannot cancel completed payroll run.');
            }

            Payslip::where('payroll_run_id', $run->id)->delete();

            $this->repository->update($run, [
                'status' => 'cancelled',
                'total_gross' => 0,
                'total_deductions' => 0,
                'total_net' => 0,
                'total_employees' => 0,
            ]);

            $this->auditService->log('cancel', $run, [], 'payroll_run');
            return $run->fresh();
        });
    }

    public function preview(int $id): array
    {
        $run = $this->find($id);
        $payslips = $run->payslips;
        $summary = [
            'total_employees' => $payslips->count(),
            'total_gross' => $payslips->sum('total_earnings'),
            'total_deductions' => $payslips->sum('total_deductions'),
            'total_net' => $payslips->sum('net_pay'),
            'highest_pay' => $payslips->max('net_pay'),
            'lowest_pay' => $payslips->min('net_pay'),
            'average_pay' => $payslips->count() ? round($payslips->avg('net_pay'), 2) : 0,
        ];
        return ['run' => $run, 'summary' => $summary, 'payslips' => $payslips];
    }

    public function getPayslips(int $runId)
    {
        return Payslip::where('payroll_run_id', $runId)
            ->with(['employee.user', 'employee.department'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getMyPayslips(int $employeeId)
    {
        return Payslip::where('employee_id', $employeeId)
            ->with('payrollRun')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function getPayslipDetail(int $id): Payslip
    {
        return Payslip::with(['payrollRun', 'employee.user', 'employee.department'])
            ->findOrFail($id);
    }

    public function createAdjustment(array $data): \App\Models\PayrollAdjustment
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $adjustment = \App\Models\PayrollAdjustment::create($data);
            $this->auditService->logCreate($adjustment, $data, 'payroll_adjustment');
            return $adjustment;
        });
    }

    public function getReport(array $filters = [])
    {
        return $this->repository->paginate(
            $filters['per_page'] ?? config('hris.pagination.default_per_page'),
            $filters
        );
    }

    private function calculateComponent(PayrollComponent $component, Employee $employee): float
    {
        return match ($component->calculation_type) {
            'fixed' => (float) $component->default_value,
            'percentage' => 0,
            'formula' => 0,
            default => 0,
        };
    }
}
