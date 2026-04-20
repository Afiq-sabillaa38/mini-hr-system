<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'position' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'join_date' => 'required|date',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'position' => $request->position,
            'basic_salary' => $request->basic_salary,
            'join_date' => $request->join_date,
        ]);

        return redirect('/admin/employees')->with('success', 'Employee added successfully');
    }

    public function edit($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'position' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'join_date' => 'required|date',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'basic_salary' => $request->basic_salary,
            'join_date' => $request->join_date,
        ]);

        return redirect('/admin/employees')->with('success', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        $employee->delete();

        return redirect('/admin/employees')->with('success', 'Employee deleted successfully');
    }
}