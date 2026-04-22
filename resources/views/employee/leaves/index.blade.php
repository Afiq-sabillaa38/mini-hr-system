<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Leaves</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-slate-950 text-white p-6 shadow-lg">
            <h2 class="text-2xl font-bold mb-8 text-white">HR System</h2>

            <nav class="space-y-3">
                <a href="/employee/dashboard"
                   class="block px-4 py-3 rounded-lg hover:bg-slate-800">
                    Dashboard
                </a>

                <a href="{{ route('employee.leaves.index') }}"
                   class="block px-4 py-3 rounded-lg bg-slate-800">
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

        <div class="flex-1 flex flex-col">

            <header class="bg-white border-b shadow-sm px-8 py-4 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-slate-900">My Leave Applications</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </header>

            <main class="p-8">
                <div class="flex justify-end mb-6">
                    <a href="{{ route('employee.leaves.create') }}"
                       class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                        Apply Leave
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow border overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Type</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Reason</th>
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
                                    <td class="px-6 py-4">{{ $leave->leave_type }}</td>
                                    <td class="px-6 py-4">{{ $leave->reason ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $leave->start_date }}</td>
                                    <td class="px-6 py-4">{{ $leave->end_date }}</td>
                                    <td class="px-6 py-4">{{ $leave->total_days }}</td>
                                    <td class="px-6 py-4 capitalize">
                                        {{ ucfirst(str_replace('_', ' ', $leave->status)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($leave->attachment_path)
                                            <a href="{{ asset('storage/' . $leave->attachment_path) }}"
                                               target="_blank"
                                               class="text-blue-600 underline">
                                                View File
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        @if(in_array($leave->status, ['pending', 'rejected']))
                                            <a href="{{ route('employee.leaves.edit', $leave->id) }}"
                                               class="inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                                Edit
                                            </a>
                                        @endif

                                        @if($leave->status === 'pending')
                                            <form action="{{ route('employee.leaves.cancel', $leave->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        onclick="return confirm('Are you sure you want to cancel this leave?')"
                                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif

                                        @if($leave->status === 'approved')
                                            <form action="{{ route('employee.leaves.requestCancel', $leave->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        onclick="return confirm('Send cancellation request to admin?')"
                                                        class="bg-orange-500 text-white px-3 py-1 rounded hover:bg-orange-600">
                                                    Request Cancel
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($leave->status, ['cancelled', 'cancel_pending']))
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