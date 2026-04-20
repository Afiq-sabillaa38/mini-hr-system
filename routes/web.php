<?php

use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/employee/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $totalEmployees = \App\Models\User::where('role', 'employee')->count();

        $pendingLeaves = \App\Models\Leave::where('status', 'pending')->count();

        $pendingClaims = \App\Models\Claim::where('status', 'Submitted')->count();

        $totalBasicSalary = \App\Models\User::where('role', 'employee')
            ->whereNotNull('basic_salary')
            ->sum('basic_salary');

        $currentMonth = now()->format('Y-m');

        $totalNetSalaryThisMonth = \App\Models\Payroll::where('month', $currentMonth)
            ->sum('net_salary');

        return view('admin.dashboard', compact(
            'totalEmployees',
            'pendingLeaves',
            'pendingClaims',
            'totalBasicSalary',
            'totalNetSalaryThisMonth'
        ));
    })->name('admin.dashboard');

    Route::resource('employees', EmployeeController::class);

    Route::get('/leaves', [LeaveController::class, 'adminIndex'])->name('admin.leaves.index');
    Route::post('/leaves/{id}/approve', [LeaveController::class, 'approve'])->name('admin.leaves.approve');
    Route::post('/leaves/{id}/reject', [LeaveController::class, 'reject'])->name('admin.leaves.reject');

    Route::get('/claims', [ClaimController::class, 'adminIndex'])->name('admin.claims.index');
    Route::post('/claims/{id}/approve', [ClaimController::class, 'approve'])->name('admin.claims.approve');
    Route::post('/claims/{id}/reject', [ClaimController::class, 'reject'])->name('admin.claims.reject');

    Route::get('/payroll', [PayrollController::class, 'index'])->name('admin.payroll.index');
    Route::post('/payroll/calculate', [PayrollController::class, 'calculate'])->name('admin.payroll.calculate');
    Route::post('/payroll/result', [PayrollController::class, 'pageResult'])->name('admin.payroll.result');
});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', function () {
        $user = auth()->user();

        $usedAnnualLeave = \App\Models\Leave::where('employee_id', $user->id)
            ->where('leave_type', 'Annual Leave')
            ->where('status', 'approved')
            ->sum('total_days');

        $leaveBalance = 14 - $usedAnnualLeave;

        $currentMonth = now()->format('Y-m');

        $latestPayslip = \App\Models\Payroll::where('employee_id', $user->id)
            ->where('month', $currentMonth)
            ->latest()
            ->first();

        $pendingClaimsCount = \App\Models\Claim::where('employee_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('employee.dashboard', compact(
            'leaveBalance',
            'latestPayslip',
            'pendingClaimsCount'
        ));
    })->name('employee.dashboard');

    Route::get('/employee/leaves', [LeaveController::class, 'index'])->name('employee.leaves.index');
    Route::get('/employee/leaves/create', [LeaveController::class, 'create'])->name('employee.leaves.create');
    Route::post('/employee/leaves', [LeaveController::class, 'store'])->name('employee.leaves.store');

    Route::get('/employee/claims', [ClaimController::class, 'index'])->name('employee.claims.index');
    Route::get('/employee/claims/create', [ClaimController::class, 'create'])->name('employee.claims.create');
    Route::post('/employee/claims', [ClaimController::class, 'store'])->name('employee.claims.store');

    Route::get('/employee/payslips', function () {
        $payslips = \App\Models\Payroll::where('employee_id', auth()->id())
            ->latest()
            ->get();

        return view('employee.payslips.index', compact('payslips'));
    })->name('employee.payslips.index');
});

require __DIR__.'/auth.php';