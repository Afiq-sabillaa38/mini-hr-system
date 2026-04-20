<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Calculator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">HR System</h2>

        <nav class="space-y-3">
            <a href="/admin/dashboard" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Dashboard</a>
            <a href="/admin/employees" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Employees</a>
            <a href="{{ route('admin.leaves.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Leaves</a>
            <a href="{{ route('admin.claims.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Claims</a>
            <a href="{{ route('admin.payroll.index') }}" class="block px-4 py-3 rounded-lg bg-slate-800">Payroll</a>
        </nav>
    </aside>

    <div class="flex-1">

        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-2xl font-bold">Payroll Calculator</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">
            <div class="bg-white rounded-xl shadow p-6 max-w-2xl">

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.payroll.result') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Employee</label>
                        <select name="employee_id" class="w-full border rounded px-3 py-2">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }} - RM {{ number_format($employee->basic_salary ?? 0, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Unpaid Leave Days</label>
                        <input type="number" name="unpaid_leave_days" min="0" value="0" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Late Minutes</label>
                        <input type="number" name="late_minutes" min="0" value="0" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Other Deductions</label>
                        <input type="number" name="other_deductions" min="0" step="0.01" value="0" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                            Calculate Payroll
                        </button>
                    </div>
                </form>

                <div class="mt-6 p-4 bg-slate-50 rounded border">
                    <p class="font-semibold mb-2">Payroll Rules</p>
                    <p>Unpaid Leave Deduction = Basic Salary / 26 × Unpaid Leave Days</p>
                    <p>Late Deduction = RM2 per minute after 30-minute grace period</p>
                    <p>EPF = 11% of (Basic Salary − Unpaid Leave Deduction)</p>
                    <p>SOCSO and EIS use simple hardcoded rates for MVP</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>