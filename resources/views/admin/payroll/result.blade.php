<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Result</title>
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
            <h1 class="text-2xl font-bold">Payroll Result</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">
            <div class="bg-white rounded-xl shadow p-6 max-w-3xl">

                <h2 class="text-xl font-bold mb-4">{{ $employee->name }}</h2>
                <p class="mb-1">Email: {{ $employee->email }}</p>
                <p class="mb-4">Position: {{ $employee->position ?? '-' }}</p>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <tbody>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">Basic Salary</td>
                                <td class="p-3">RM {{ number_format($result['basic_salary'], 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">Unpaid Leave Days</td>
                                <td class="p-3">{{ $result['unpaid_leave_days'] }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">Unpaid Leave Deduction</td>
                                <td class="p-3">RM {{ number_format($result['unpaid_leave_deduction'], 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">Late Minutes</td>
                                <td class="p-3">{{ $result['late_minutes'] }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">Chargeable Late Minutes</td>
                                <td class="p-3">{{ $result['chargeable_late_minutes'] }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">Late Deduction</td>
                                <td class="p-3">RM {{ number_format($result['late_deduction'], 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">Other Deductions</td>
                                <td class="p-3">RM {{ number_format($result['other_deductions'], 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">EPF</td>
                                <td class="p-3">RM {{ number_format($result['epf'], 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">SOCSO</td>
                                <td class="p-3">RM {{ number_format($result['socso'], 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-3 font-semibold">EIS</td>
                                <td class="p-3">RM {{ number_format($result['eis'], 2) }}</td>
                            </tr>
                            <tr class="border-b bg-slate-50">
                                <td class="p-3 font-bold">Total Deductions</td>
                                <td class="p-3 font-bold">RM {{ number_format($result['total_deductions'], 2) }}</td>
                            </tr>
                            <tr class="bg-green-50">
                                <td class="p-3 font-bold">Net Salary</td>
                                <td class="p-3 font-bold text-green-700">RM {{ number_format($result['net_salary'], 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.payroll.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Back to Payroll Form
                    </a>
                </div>

                <div class="mt-6">
                    <h3 class="font-bold mb-2">JSON Preview</h3>
                    <pre class="bg-slate-900 text-white p-4 rounded overflow-x-auto text-sm">{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>