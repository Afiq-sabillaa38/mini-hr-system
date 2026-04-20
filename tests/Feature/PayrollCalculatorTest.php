<?php

namespace Tests\Feature;

use App\Services\PayrollCalculator;
use Tests\TestCase;

class PayrollCalculatorTest extends TestCase
{
    public function test_payroll_with_no_unpaid_leave_and_no_late_minutes(): void
    {
        $calculator = new PayrollCalculator();

        $result = $calculator->calculate(3500, 0, 0, 0);

        $this->assertEquals(3500.00, $result['basic_salary']);
        $this->assertEquals(0, $result['unpaid_leave_days']);
        $this->assertEquals(0.00, $result['unpaid_leave_deduction']);
        $this->assertEquals(0, $result['late_minutes']);
        $this->assertEquals(0, $result['chargeable_late_minutes']);
        $this->assertEquals(0.00, $result['late_deduction']);
        $this->assertEquals(385.00, $result['epf']);
        $this->assertEquals(29.75, $result['socso']);
        $this->assertEquals(11.90, $result['eis']);
        $this->assertEquals(426.65, $result['total_deductions']);
        $this->assertEquals(3073.35, $result['net_salary']);
    }

    public function test_payroll_with_unpaid_leave_deduction(): void
    {
        $calculator = new PayrollCalculator();

        $result = $calculator->calculate(2800, 2, 0, 0);

        $this->assertEquals(2800.00, $result['basic_salary']);
        $this->assertEquals(2, $result['unpaid_leave_days']);
        $this->assertEquals(215.38, $result['unpaid_leave_deduction']);
        $this->assertEquals(0.00, $result['late_deduction']);
        $this->assertEquals(284.31, $result['epf']);
        $this->assertEquals(19.75, $result['socso']);
        $this->assertEquals(7.90, $result['eis']);
        $this->assertEquals(527.34, $result['total_deductions']);
        $this->assertEquals(2272.66, $result['net_salary']);
    }

    public function test_payroll_with_late_minutes_after_grace_period(): void
    {
        $calculator = new PayrollCalculator();

        $result = $calculator->calculate(3500, 0, 35, 0);

        $this->assertEquals(35, $result['late_minutes']);
        $this->assertEquals(5, $result['chargeable_late_minutes']);
        $this->assertEquals(10.00, $result['late_deduction']);
        $this->assertEquals(436.65, $result['total_deductions']);
        $this->assertEquals(3063.35, $result['net_salary']);
    }

    public function test_payroll_with_other_deductions(): void
    {
        $calculator = new PayrollCalculator();

        $result = $calculator->calculate(3500, 0, 35, 100);

        $this->assertEquals(100.00, $result['other_deductions']);
        $this->assertEquals(536.65, $result['total_deductions']);
        $this->assertEquals(2963.35, $result['net_salary']);
    }
}