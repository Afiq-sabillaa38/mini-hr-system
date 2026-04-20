<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">

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
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">

            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Edit Employee</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </header>

            <main class="p-6">
                <div class="max-w-2xl bg-white rounded-xl shadow-md p-6">

                    <form method="POST" action="{{ route('employees.update', $employee->id) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" value="{{ $employee->name }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ $employee->email }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                            <input type="text" name="position" value="{{ $employee->position }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Basic Salary</label>
                            <input type="number" step="0.01" name="basic_salary" value="{{ $employee->basic_salary }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Join Date</label>
                            <input type="date" name="join_date" value="{{ $employee->join_date }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <button type="submit"
                                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                                Update Employee
                            </button>
                        </div>

                    </form>

                </div>
            </main>

        </div>
    </div>

</body>
</html>