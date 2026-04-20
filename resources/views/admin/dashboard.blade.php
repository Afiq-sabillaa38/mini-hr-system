<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">HR System</h2>

        <nav class="space-y-3">
            <a href="/admin/dashboard"
               class="block px-4 py-3 rounded-lg bg-slate-800">
                Dashboard
            </a>

            <a href="/admin/employees"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Employees
            </a>

            <a href="{{ route('admin.leaves.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Leaves
            </a>

            <a href="{{ route('admin.claims.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Claims
            </a>

            <a href="{{ route('admin.payroll.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Payroll
            </a>
        </nav>
    </aside>

    <div class="flex-1">

        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

       <div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-sm font-semibold text-slate-500">Total Employees</h2>
            <p class="text-3xl font-bold text-slate-900 mt-3">
                {{ $totalEmployees }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-sm font-semibold text-slate-500">Pending Leaves</h2>
            <p class="text-3xl font-bold text-yellow-600 mt-3">
                {{ $pendingLeaves }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-sm font-semibold text-slate-500">Pending Claims</h2>
            <p class="text-3xl font-bold text-orange-600 mt-3">
                {{ $pendingClaims }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-sm font-semibold text-slate-500">Total Basic Salary</h2>
            <p class="text-3xl font-bold text-blue-600 mt-3">
                RM {{ number_format($totalBasicSalary, 2) }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-sm font-semibold text-slate-500">Total Net Salary This Month</h2>
            <p class="text-3xl font-bold text-green-600 mt-3">
                RM {{ number_format($totalNetSalaryThisMonth, 2) }}
            </p>
        </div>

    </div>
</div>

    </div>
</div>

</body>
</html>