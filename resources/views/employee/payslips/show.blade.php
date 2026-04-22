<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip Details</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">HR System</h2>

        <nav class="space-y-3">
            <a href="/employee/dashboard"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Dashboard
            </a>

            <a href="{{ route('employee.leaves.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                My Leaves
            </a>

            <a href="{{ route('employee.claims.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                My Claims
            </a>

            <a href="{{ route('employee.payslips.index') }}"
               class="block px-4 py-3 rounded-lg bg-slate-800">
                My Payslips
            </a>
        </nav>
    </aside>

    <div class="flex-1">

        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-2xl font-bold">Payslip Details</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">
            <div class="bg-white rounded-2xl shadow p-6 max-w-4xl">
                <h2 class="text-xl font-bold mb-4">Month: {{ $payslip->month }}</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border border-slate-200">
                        <tbody>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50 w-1/2">Basic Salary</th>
                                <td class="p-4">RM {{ number_format($payslip->basic_salary, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">Unpaid Leave Days</th>
                                <td class="p-4">{{ $payslip->unpaid_leave_days }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">Unpaid Leave Deduction</th>
                                <td class="p-4">RM {{ number_format($payslip->unpaid_leave_deduction, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">Late Minutes</th>
                                <td class="p-4">{{ $payslip->late_minutes }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">Chargeable Late Minutes</th>
                                <td class="p-4">{{ $payslip->chargeable_late_minutes }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">Late Deduction</th>
                                <td class="p-4">RM {{ number_format($payslip->late_deduction, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">Other Deductions</th>
                                <td class="p-4">RM {{ number_format($payslip->other_deductions, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">EPF</th>
                                <td class="p-4">RM {{ number_format($payslip->epf, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">SOCSO</th>
                                <td class="p-4">RM {{ number_format($payslip->socso, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="text-left p-4 bg-slate-50">EIS</th>
                                <td class="p-4">RM {{ number_format($payslip->eis, 2) }}</td>
                            </tr>
                            <tr class="border-b font-semibold">
                                <th class="text-left p-4 bg-slate-50">Total Deductions</th>
                                <td class="p-4">RM {{ number_format($payslip->total_deductions, 2) }}</td>
                            </tr>
                            <tr class="font-bold text-green-600">
                                <th class="text-left p-4 bg-slate-50">Net Salary</th>
                                <td class="p-4">RM {{ number_format($payslip->net_salary, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('employee.payslips.index') }}"
                       class="bg-slate-600 text-white px-4 py-2 rounded hover:bg-slate-700">
                        Back
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>