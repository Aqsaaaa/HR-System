<?php

namespace Database\Seeders;

use App\Models\PayrollComponent;
use App\Models\PayrollRun;
use App\Models\Payslip;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        $components = [
            ['name' => 'Basic Salary', 'code' => 'BASIC', 'type' => 'earning', 'calculation_type' => 'fixed', 'default_value' => 5000000, 'sort_order' => 1, 'is_taxable' => true],
            ['name' => 'Health Insurance', 'code' => 'HEALTH', 'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 150000, 'sort_order' => 1],
            ['name' => 'Transport Allowance', 'code' => 'TRANSPORT', 'type' => 'earning', 'calculation_type' => 'fixed', 'default_value' => 500000, 'sort_order' => 2],
            ['name' => 'Meal Allowance', 'code' => 'MEAL', 'type' => 'earning', 'calculation_type' => 'fixed', 'default_value' => 300000, 'sort_order' => 3],
            ['name' => 'Pension Fund', 'code' => 'PENSION', 'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 250000, 'sort_order' => 2],
            ['name' => 'Income Tax', 'code' => 'TAX', 'type' => 'deduction', 'calculation_type' => 'fixed', 'default_value' => 250000, 'sort_order' => 3],
        ];

        foreach ($components as $data) {
            $data['created_by'] = 1;
            PayrollComponent::create($data);
        }

        $now = Carbon::parse('2000-08-01');
        $employees = Employee::all();

        $run = PayrollRun::create([
            'name' => 'Monthly Payroll - ' . $now->format('F Y'),
            'period_type' => 'monthly',
            'month' => $now->month,
            'year' => $now->year,
            'period_start' => $now->format('Y-m-d'),
            'period_end' => $now->copy()->endOfMonth()->format('Y-m-d'),
            'payment_date' => $now->copy()->endOfMonth()->format('Y-m-d'),
            'status' => 'completed',
            'total_gross' => 0,
            'total_deductions' => 0,
            'total_net' => 0,
            'total_employees' => $employees->count(),
            'created_by' => 1,
            'completed_at' => $now,
        ]);

        $earningsComps = PayrollComponent::where('type', 'earning')->get();
        $deductionsComps = PayrollComponent::where('type', 'deduction')->get();
        $totalGross = 0;
        $totalDeductions = 0;

        foreach ($employees as $i => $employee) {
            $earnings = [];
            $deductions = [];
            $totalEarnings = 0;
            $totalDedEmp = 0;

            foreach ($earningsComps as $comp) {
                $earnings[] = ['name' => $comp->name, 'code' => $comp->code, 'amount' => $comp->default_value];
                $totalEarnings += $comp->default_value;
            }
            foreach ($deductionsComps as $comp) {
                $deductions[] = ['name' => $comp->name, 'code' => $comp->code, 'amount' => $comp->default_value];
                $totalDedEmp += $comp->default_value;
            }

            Payslip::create([
                'payslip_no' => 'PSL-' . $run->id . '-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'payroll_run_id' => $run->id,
                'employee_id' => $employee->id,
                'basic_salary' => 5000000,
                'earnings' => $earnings,
                'deductions' => $deductions,
                'total_earnings' => $totalEarnings,
                'total_deductions' => $totalDedEmp,
                'net_pay' => $totalEarnings - $totalDedEmp,
                'status' => 'paid',
                'paid_at' => $now,
                'created_by' => 1,
            ]);

            $totalGross += $totalEarnings;
            $totalDeductions += $totalDedEmp;
        }

        $run->update([
            'total_gross' => $totalGross,
            'total_deductions' => $totalDeductions,
            'total_net' => $totalGross - $totalDeductions,
        ]);
    }
}
