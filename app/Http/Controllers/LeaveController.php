<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::where('employee_id', auth()->id())->latest()->get();
        return view('employee.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('employee.leaves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->leave_type === 'Sick Leave' && !$request->hasFile('attachment')) {
            return back()->withErrors([
                'attachment' => 'MC attachment is required for Sick Leave.'
            ])->withInput();
        }

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
                return back()->withErrors([
                    'start_date' => 'Annual leave balance is not enough. Remaining: ' . $remainingBalance . ' days.'
                ])->withInput();
            }
        }

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        Leave::create([
            'employee_id' => auth()->id(),
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.leaves.index')->with('success', 'Leave applied successfully.');
    }

    public function adminIndex()
    {
        $leaves = Leave::with('employee')->latest()->get();
        return view('admin.leaves.index', compact('leaves'));
    }

    public function approve($id)
{
    $leave = Leave::findOrFail($id);

    if ($leave->status !== 'pending') {
        return back()->with('success', 'This leave has already been processed.');
    }

    $leave->update([
        'status' => 'approved',
        'remarks' => 'Approved by admin',
    ]);

    return back()->with('success', 'Leave approved successfully.');
}

public function reject($id)
{
    $leave = Leave::findOrFail($id);

    if ($leave->status !== 'pending') {
        return back()->with('success', 'This leave has already been processed.');
    }

    $leave->update([
        'status' => 'rejected',
        'remarks' => 'Rejected by admin',
    ]);

    return back()->with('success', 'Leave rejected successfully.');
}
}