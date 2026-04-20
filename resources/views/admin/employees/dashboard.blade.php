<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-5">
            <h2 class="text-2xl font-bold mb-8">HR System</h2>

            <nav class="space-y-2">
                <a href="/admin/dashboard"
                   class="block px-4 py-2 rounded hover:bg-gray-700 hover:text-white transition">
                    Dashboard
                </a>

                <a href="/admin/employees"
                   class="block px-4 py-2 rounded bg-gray-700 text-white">
                    Employees
                </a>
                <a href="{{ route('employee.claims.index') }}"
   class="block px-4 py-3 rounded-lg hover:bg-slate-800">
    My Claims
</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Employee List</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </header>

            <!-- Content -->
            <main class="p-6">

                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('employees.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Add Employee
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-gray-700">Name</th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-700">Email</th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $emp)
                                <tr class="border-t">
                                    <td class="px-6 py-4 text-gray-800">{{ $emp->name }}</td>
                                    <td class="px-6 py-4 text-gray-800">{{ $emp->email }}</td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('employees.edit', $emp->id) }}"
                                           class="inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                            Edit
                                        </a>

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
                                    <td colspan="3" class="px-6 py-6 text-center text-gray-500">
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