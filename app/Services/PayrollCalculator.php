<?php

namespace App\Services;

class PayrollCalculator
{
    public function calculate(
        float $basicSalary,
        int $unpaidLeaveDays,
        int $lateMinutes,
        float $otherDeductions = 0
    ): array {
        $unpaidLeaveDeduction = round(($basicSalary / 26) * $unpaidLeaveDays, 2);

        $chargeableLateMinutes = max($lateMinutes - 30, 0);
        $lateDeduction = round($chargeableLateMinutes * 2, 2);

        $epfBase = $basicSalary - $unpaidLeaveDeduction;
        $epf = round($epfBase * 0.11, 2);

        $socso = $this->getSocso($basicSalary);
        $eis = $this->getEis($basicSalary);

        $totalDeductions = round(
            $unpaidLeaveDeduction +
            $lateDeduction +
            $otherDeductions +
            $epf +
            $socso +
            $eis,
            2
        );

        $netSalary = round($basicSalary - $totalDeductions, 2);

        return [
            'basic_salary' => round($basicSalary, 2),
            'unpaid_leave_days' => $unpaidLeaveDays,
            'unpaid_leave_deduction' => $unpaidLeaveDeduction,
            'late_minutes' => $lateMinutes,
            'chargeable_late_minutes' => $chargeableLateMinutes,
            'late_deduction' => $lateDeduction,
            'other_deductions' => round($otherDeductions, 2),
            'epf' => $epf,
            'socso' => $socso,
            'eis' => $eis,
            'total_deductions' => $totalDeductions,
            'net_salary' => $netSalary,
        ];
    }

    private function getSocso(float $salary): float
    {
        if ($salary <= 3000) {
            return 19.75;
        }

        if ($salary <= 5000) {
            return 29.75;
        }

        return 39.75;
    }

    private function getEis(float $salary): float
    {
        if ($salary <= 3000) {
            return 7.90;
        }

        if ($salary <= 5000) {
            return 11.90;
        }

        return 19.80;
    }
}