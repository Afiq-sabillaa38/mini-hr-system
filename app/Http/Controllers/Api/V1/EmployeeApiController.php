<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;

class EmployeeApiController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')
            ->select('id', 'name', 'email', 'position', 'basic_salary', 'join_date')
            ->get();

        return response()->json([
            'message' => 'Employees retrieved successfully',
            'data' => $employees,
        ]);
    }
}