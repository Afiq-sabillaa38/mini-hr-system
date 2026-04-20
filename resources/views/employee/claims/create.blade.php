<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Claim</title>
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
               class="block px-4 py-3 rounded-lg bg-slate-800">
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
            <h1 class="text-2xl font-bold">Apply Claim</h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">
            <div class="bg-white rounded-xl shadow p-6 max-w-2xl">

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('employee.claims.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Claim Type</label>
                        <select name="claim_type" class="w-full border rounded px-3 py-2">
                            <option value="">Select Claim Type</option>
                            <option value="Medical Claim" {{ old('claim_type') == 'Medical Claim' ? 'selected' : '' }}>Medical Claim</option>
                            <option value="Travel Claim" {{ old('claim_type') == 'Travel Claim' ? 'selected' : '' }}>Travel Claim</option>
                            <option value="Meal Claim" {{ old('claim_type') == 'Meal Claim' ? 'selected' : '' }}>Meal Claim</option>
                            <option value="Other Claim" {{ old('claim_type') == 'Other Claim' ? 'selected' : '' }}>Other Claim</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Amount</label>
                        <input type="number" step="0.01" min="0.01" name="amount" value="{{ old('amount') }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Claim Date</label>
                        <input type="date" id="claim_date" name="claim_date" value="{{ old('claim_date') }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Description</label>
                        <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Receipt</label>
                        <input type="file" name="receipt" class="w-full border rounded px-3 py-2">
                        <p class="text-sm text-gray-500 mt-1">Upload JPG, PNG or PDF. Max 5MB.</p>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                        Submit Claim
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const claimDate = document.getElementById('claim_date');
    const today = new Date().toISOString().split('T')[0];
    claimDate.max = today;
</script>

</body>
</html>