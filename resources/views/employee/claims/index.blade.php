<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Claims</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-950 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">HR System</h2>

        <nav class="space-y-3">
            <a href="/employee/dashboard" class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                Dashboard
            </a>

            <a href="{{ route('employee.leaves.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                My Leaves
            </a>

            <a href="{{ route('employee.claims.index') }}" class="block px-4 py-3 rounded-lg bg-slate-800">
                My Claims
            </a>

            <a href="{{ route('employee.payslips.index') }}"
   class="block px-4 py-3 rounded-lg hover:bg-slate-800">
    My Payslips
</a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="flex-1">

        <!-- Header -->
        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-2xl font-bold">My Claims</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <!-- Content -->
        <div class="p-6">

            <div class="flex justify-end mb-4">
                <a href="{{ route('employee.claims.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded">
                    Apply Claim
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded shadow p-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($claims as $claim)
                            <tr class="border-b">
                                <td>{{ $claim->claim_type }}</td>
                                <td>RM {{ number_format($claim->amount, 2) }}</td>
                                <td>{{ $claim->claim_date }}</td>
                                <td>{{ ucfirst($claim->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    No claims found.
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