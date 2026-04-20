<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">HR System</h2>

        <nav class="space-y-3">
            <a href="/admin/dashboard"
               class="block px-4 py-3 rounded-lg hover:bg-slate-800">
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
               class="block px-4 py-3 rounded-lg bg-slate-800">
                Claims
            </a>

            <a href="{{ route('admin.payroll.index') }}"
               class="block px-4 py-3 rounded-lg text-white font-medium hover:bg-slate-800 transition">
                Payroll
            </a>
        </nav>
    </aside>

    <div class="flex-1">

        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-2xl font-bold">Claim Management</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-4 overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-3">Employee</th>
                            <th class="py-3">Title</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Amount</th>
                            <th class="py-3">Receipt</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Remarks</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($claims as $claim)
                            <tr class="border-b">
                                <td class="py-3">{{ $claim->employee->name ?? 'N/A' }}</td>
                                <td class="py-3">{{ $claim->title }}</td>
                                <td class="py-3">{{ $claim->category }}</td>
                                <td class="py-3">RM {{ number_format($claim->amount, 2) }}</td>
                                <td class="py-3">
                                    @if($claim->receipt_upload)
                                        <a href="{{ asset('storage/' . $claim->receipt_upload) }}" target="_blank" class="text-blue-600 underline">
                                            View Receipt
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3">{{ $claim->status }}</td>
                                <td class="py-3">{{ $claim->remarks ?? '-' }}</td>
                                <td class="py-3">
                                    @if($claim->status === 'Submitted')
                                        <form action="{{ route('admin.claims.approve', $claim->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-green-600 text-white px-3 py-1 rounded">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.claims.reject', $claim->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                                Reject
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
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