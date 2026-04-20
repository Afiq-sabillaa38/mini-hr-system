<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-slate-950 text-white p-6 shadow-lg">
            <h2 class="text-2xl font-bold mb-8 text-white">HR System</h2>

            <nav class="space-y-3">
                <a href="/admin/dashboard"
                   class="block px-4 py-3 rounded-lg text-white font-medium hover:bg-slate-800 transition">
                    Dashboard
                </a>

                <a href="/admin/employees"
                   class="block px-4 py-3 rounded-lg bg-slate-800 text-white font-medium">
                    Employees
                </a>

                <a href="{{ route('admin.leaves.index') }}"
   class="block px-4 py-3 rounded-lg text-white font-medium hover:bg-slate-800 transition">
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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-white border-b shadow-sm px-8 py-4 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-slate-900">Employees</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </header>

            <!-- Content -->
            <main class="p-8">

                <!-- Add Button -->
                <div class="flex justify-end mb-6">
                    <a href="{{ route('employees.create') }}"
                       class="bg-blue-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                        Add Employee
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table -->
                <div class="bg-white rounded-2xl shadow border overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-slate-700">Name</th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-700">Email</th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-700">Position</th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-700">Basic Salary</th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-700">Join Date</th>
                                <th class="text-left px-6 py-4 font-semibold text-slate-700">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($employees as $emp)
                                <tr class="border-t hover:bg-slate-50">

                                    <td class="px-6 py-4 text-slate-800">
                                        {{ $emp->name }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-800">
                                        {{ $emp->email }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-800">
                                        {{ $emp->position ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-800">
                                        {{ $emp->basic_salary ? number_format($emp->basic_salary, 2) : '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-800">
                                        {{ $emp->join_date ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 space-x-2">

                                        <!-- Edit -->
                                        <a href="{{ route('employees.edit', $emp->id) }}"
                                           class="inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('employees.destroy', $emp->id) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Delete this employee?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                            @empty
                                <tr class="border-t">
                                    <td colspan="6" class="px-6 py-6 text-center text-slate-500">
                                        No employees found.
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