<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Leave</title>
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
                <h1 class="text-3xl font-bold text-slate-900">Apply Leave</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </header>

            <main class="p-8">
                <div class="max-w-2xl bg-white rounded-xl shadow-md p-6">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employee.leaves.store') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <!-- Leave Type -->
    <div>
        <label class="block mb-1">Leave Type</label>
        <select name="leave_type" class="w-full border rounded px-3 py-2">
            <option value="Annual Leave">Annual Leave</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Unpaid Leave">Unpaid Leave</option>
        </select>
    </div>

    <!-- Start Date -->
    <div>
        <label class="block mb-1">Start Date</label>
        <input type="date" id="start_date" name="start_date" 
               class="w-full border rounded px-3 py-2">
    </div>

    <!-- End Date -->
    <div>
        <label class="block mb-1">End Date</label>
        <input type="date" id="end_date" name="end_date" 
               class="w-full border rounded px-3 py-2">
    </div>

    <!-- Reason -->
    <div>
        <label class="block mb-1">Reason</label>
        <textarea name="reason" class="w-full border rounded px-3 py-2"></textarea>
    </div>

    <!-- Attachment -->
    <div>
        <label class="block mb-1">Attachment</label>
        <input type="file" name="attachment" class="w-full border rounded px-3 py-2">
        <small class="text-gray-500">
            JPG, PNG, PDF only. Max 5MB. MC required for Sick Leave.
        </small>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
        Submit Leave
    </button>
</form>

                </div>
            </main>

        </div>
    </div>

    <script>
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    // Prevent past dates
    const today = new Date().toISOString().split('T')[0];
    startDate.min = today;
    endDate.min = today;

    startDate.addEventListener('change', function () {
        // Set minimum end date = start date
        endDate.min = this.value;

        // Reset invalid end date
        if (endDate.value && endDate.value < this.value) {
            endDate.value = '';
        }
    });
</script>

</body>
</html>