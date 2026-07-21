<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PayrollComponent;
use App\Models\PayrollRun;
use App\Services\Payroll\PayrollRunService;
use Inertia\Inertia;

class PayrollController extends Controller
{
    public function __construct(
        private PayrollRunService $payrollRunService
    ) {}

    public function index()
    {
        $runs = $this->payrollRunService->getAll(request()->all());
        $components = PayrollComponent::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Payroll/Index', [
            'runs' => $runs,
            'components' => $components,
            'filters' => request()->all(),
        ]);
    }
}
