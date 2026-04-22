<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h2 class="text-2xl font-bold mb-8">HR System</h2>

        <nav class="space-y-3">
            <a href="/employee/dashboard" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Dashboard</a>
            <a href="{{ route('employee.leaves.index') }}" class="block px-4 py-3 rounded-lg bg-slate-800">My Leaves</a>
            <a href="{{ route('employee.claims.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800">My Claims</a>
            <a href="{{ route('employee.payslips.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-800">My Payslips</a>
        </nav>
    </aside>

    <div class="flex-1">
        <div class="flex justify-between items-center p-6 bg-white shadow">
            <h1 class="text-2xl font-bold">Edit Leave</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
            </form>
        </div>

        <div class="p-6">
            <div class="bg-white rounded-2xl shadow p-6 max-w-2xl">
                <form action="{{ route('employee.leaves.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Leave Type</label>
                        <select name="leave_type" class="w-full border rounded px-4 py-2">
                            <option value="Annual Leave" {{ $leave->leave_type === 'Annual Leave' ? 'selected' : '' }}>Annual Leave</option>
                            <option value="Sick Leave" {{ $leave->leave_type === 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="Unpaid Leave" {{ $leave->leave_type === 'Unpaid Leave' ? 'selected' : '' }}>Unpaid Leave</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Start Date</label>
                        <input type="date" name="start_date" value="{{ $leave->start_date }}" class="w-full border rounded px-4 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">End Date</label>
                        <input type="date" name="end_date" value="{{ $leave->end_date }}" class="w-full border rounded px-4 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Reason</label>
                        <textarea name="reason" class="w-full border rounded px-4 py-2">{{ $leave->reason }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Attachment</label>
                        <input type="file" name="attachment" class="w-full border rounded px-4 py-2">
                        @if($leave->attachment_path)
                            <p class="mt-2 text-sm">
                                Current file:
                                <a href="{{ asset('storage/' . $leave->attachment_path) }}" target="_blank" class="text-blue-600 underline">
                                    View File
                                </a>
                            </p>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update Leave
                        </button>

                        <a href="{{ route('employee.leaves.index') }}" class="bg-slate-500 text-white px-4 py-2 rounded hover:bg-slate-600">
                            Back
                        </a>
                    </div>
                </form>

                @if($errors->any())
                    <div class="mt-4 bg-red-100 text-red-700 p-4 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

</body>
</html>