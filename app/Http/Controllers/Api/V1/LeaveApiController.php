<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveApiController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        $totalDays = 0;
        $current = $start->copy();

        while ($current->lte($end)) {
            if (!$current->isWeekend()) {
                $totalDays++;
            }
            $current->addDay();
        }

        if ($request->leave_type === 'Annual Leave') {
            $usedAnnualLeave = Leave::where('employee_id', auth()->id())
                ->where('leave_type', 'Annual Leave')
                ->where('status', 'approved')
                ->sum('total_days');

            $remainingBalance = 14 - $usedAnnualLeave;

            if ($totalDays > $remainingBalance) {
                return response()->json([
                    'message' => 'Annual leave balance is not enough',
                    'remaining_balance' => $remainingBalance,
                ], 422);
            }
        }

        $leave = Leave::create([
            'employee_id' => auth()->id(),
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'attachment_path' => null,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Leave applied successfully',
            'data' => $leave,
        ], 201);
    }
}