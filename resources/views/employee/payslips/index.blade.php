<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Payslip History</title>
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
            <h1 class="text-2xl font-bold">My Payslip History</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">
            <div class="bg-white rounded-2xl shadow p-6 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="py-3">Month</th>
                            <th class="py-3">Basic Salary</th>
                            <th class="py-3">Total Deductions</th>
                            <th class="py-3">Net Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payslips as $payslip)
                            <tr class="border-b">
                                <td class="py-3">{{ $payslip->month }}</td>
                                <td class="py-3">RM {{ number_format($payslip->basic_salary, 2) }}</td>
                                <td class="py-3">RM {{ number_format($payslip->total_deductions, 2) }}</td>
                                <td class="py-3 font-semibold text-green-600">
                                    RM {{ number_format($payslip->net_salary, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-500">
                                    No payslip history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>