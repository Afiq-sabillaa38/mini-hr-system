<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'basic_salary',
        'unpaid_leave_days',
        'unpaid_leave_deduction',
        'late_minutes',
        'chargeable_late_minutes',
        'late_deduction',
        'other_deductions',
        'epf',
        'socso',
        'eis',
        'total_deductions',
        'net_salary',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}