<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\User;
use App\Services\PayrollCalculator;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return view('admin.payroll.index', compact('employees'));
    }

    public function calculate(Request $request, PayrollCalculator $calculator)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'unpaid_leave_days' => 'required|integer|min:0',
            'late_minutes' => 'required|integer|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
        ]);

        $employee = User::where('role', 'employee')->findOrFail($request->employee_id);

        $result = $calculator->calculate(
            (float) $employee->basic_salary,
            (int) $request->unpaid_leave_days,
            (int) $request->late_minutes,
            (float) ($request->other_deductions ?? 0)
        );

        return response()->json([
            'employee' => [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'position' => $employee->position,
            ],
            'payroll' => $result,
        ]);
    }

    public function pageResult(Request $request, PayrollCalculator $calculator)
{
    $request->validate([
        'employee_id' => 'required|exists:users,id',
        'unpaid_leave_days' => 'required|integer|min:0',
        'late_minutes' => 'required|integer|min:0',
        'other_deductions' => 'nullable|numeric|min:0',
    ]);

    $employee = User::where('role', 'employee')->findOrFail($request->employee_id);

    $result = $calculator->calculate(
        (float) $employee->basic_salary,
        (int) $request->unpaid_leave_days,
        (int) $request->late_minutes,
        (float) ($request->other_deductions ?? 0)
    );

    $month = now()->format('Y-m');

    Payroll::updateOrCreate(
        [
            'employee_id' => $employee->id,
            'month' => $month,
        ],
        [
            'basic_salary' => $result['basic_salary'],
            'unpaid_leave_days' => $result['unpaid_leave_days'],
            'unpaid_leave_deduction' => $result['unpaid_leave_deduction'],
            'late_minutes' => $result['late_minutes'],
            'chargeable_late_minutes' => $result['chargeable_late_minutes'],
            'late_deduction' => $result['late_deduction'],
            'other_deductions' => $result['other_deductions'],
            'epf' => $result['epf'],
            'socso' => $result['socso'],
            'eis' => $result['eis'],
            'total_deductions' => $result['total_deductions'],
            'net_salary' => $result['net_salary'],
        ]
    );

    return view('admin.payroll.result', compact('employee', 'result'));
}
}