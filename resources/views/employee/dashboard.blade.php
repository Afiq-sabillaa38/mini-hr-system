<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">HR System</h2>

        <nav class="space-y-3">
            <a href="/employee/dashboard"
               class="block px-4 py-3 rounded-lg bg-slate-800">
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
   class="block px-4 py-3 rounded-lg hover:bg-slate-800">
    My Payslips
</a>
        </nav>
    </aside>

    <div class="flex-1">

        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-2xl font-bold">Employee Dashboard</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-sm font-semibold text-slate-500">Leave Balance</h2>
                    <p class="text-3xl font-bold text-green-600 mt-3">
                        {{ $leaveBalance }} days
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-sm font-semibold text-slate-500">Latest Payslip Net Amount</h2>
                    <p class="text-3xl font-bold text-blue-600 mt-3">
                        @if($latestPayslip)
                            RM {{ number_format($latestPayslip->net_salary, 2) }}
                        @else
                            RM 0.00
                        @endif
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-sm font-semibold text-slate-500">Pending Claims</h2>
                    <p class="text-3xl font-bold text-orange-600 mt-3">
                        {{ $pendingClaimsCount }}
                    </p>
                </div>

            </div>

            <div class="mt-8 bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-bold mb-4">My Profile</h2>

                <div class="space-y-3">
                    <p><span class="font-semibold">Name:</span> {{ auth()->user()->name }}</p>
                    <p><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p>
                    <p><span class="font-semibold">Position:</span> {{ auth()->user()->position ?? '-' }}</p>
                    <p><span class="font-semibold">Basic Salary:</span> RM {{ number_format(auth()->user()->basic_salary ?? 0, 2) }}</p>
                    <p><span class="font-semibold">Join Date:</span> {{ auth()->user()->join_date ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>