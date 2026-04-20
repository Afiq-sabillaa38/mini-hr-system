<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-slate-950 text-white p-6 shadow-lg">
            <h2 class="text-2xl font-bold mb-8 text-white">HR System</h2>

            <nav class="space-y-3">
                <a href="/admin/dashboard"
                   class="block px-4 py-3 rounded-lg text-white font-medium hover:bg-slate-800 transition">
                    Dashboard
                </a>

                <a href="/admin/employees"
                   class="block px-4 py-3 rounded-lg text-white font-medium hover:bg-slate-800 transition">
                    Employees
                </a>

              <a href="{{ route('admin.leaves.index') }}"
   class="block px-4 py-3 rounded-lg bg-slate-800 text-white font-medium">
    Leaves
</a>

<a href="{{ route('admin.claims.index') }}"
   class="block px-4 py-3 rounded-lg text-white font-medium hover:bg-slate-800 transition">
    Claims
</a>

<a href="{{ route('admin.payroll.index') }}"
   class="block px-4 py-3 rounded-lg text-white font-medium hover:bg-slate-800 transition">
    Payroll
</a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">

            <header class="bg-white border-b shadow-sm px-8 py-4 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-slate-900">Leave Management</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </header>

            <main class="p-8">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow border overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Employee</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Type</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Start Date</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">End Date</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Total Days</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Status</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Attachment</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $leave)
                                <tr class="border-t">
                                    <td class="px-6 py-4">{{ $leave->employee->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $leave->leave_type }}</td>
                                    <td class="px-6 py-4">{{ $leave->start_date }}</td>
                                    <td class="px-6 py-4">{{ $leave->end_date }}</td>
                                    <td class="px-6 py-4">{{ $leave->total_days }}</td>
                                    <td class="px-6 py-4 capitalize">{{ $leave->status }}</td>
                                    <td class="px-6 py-4">
                                        @if($leave->attachment_path)
                                            <a href="{{ asset('storage/' . $leave->attachment_path) }}" target="_blank" class="text-blue-600 underline">
                                                View File
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        @if($leave->status === 'pending')
                                            <form action="{{ route('admin.leaves.approve', $leave->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="bg-green-600 text-white px-3 py-1 rounded">Approve</button>
                                            </form>

                                            <form action="{{ route('admin.leaves.reject', $leave->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                                            </form>
                                        @else
                                            <span class="text-slate-500">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t">
                                    <td colspan="8" class="px-6 py-6 text-center text-slate-500">
                                        No leave applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
    </div>

</body>
</html>