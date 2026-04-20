<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;

class PayslipApiController extends Controller
{
    public function show($employee_id, $month)
    {
        $employee = User::where('role', 'employee')->find($employee_id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        $payslip = Payroll::where('employee_id', $employee_id)
            ->where('month', $month)
            ->first();

        if (!$payslip) {
            return response()->json([
                'message' => 'Payslip not found for this month'
            ], 404);
        }

        return response()->json([
            'message' => 'Payslip retrieved successfully',
            'employee' => [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'position' => $employee->position,
            ],
            'payslip' => $payslip,
        ]);
    }
}