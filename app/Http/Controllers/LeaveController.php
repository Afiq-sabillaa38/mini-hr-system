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

        $totalDays = $this->calculateWorkingDays($request->start_date, $request->end_date);

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
            'remarks' => null,
        ]);

        return redirect()->route('employee.leaves.index')->with('success', 'Leave applied successfully.');
    }

    public function edit($id)
    {
        $leave = Leave::where('employee_id', auth()->id())->findOrFail($id);

        if (!in_array($leave->status, ['pending', 'rejected'])) {
            return back()->with('error', 'Only pending or rejected leave can be edited.');
        }

        return view('employee.leaves.edit', compact('leave'));
    }

    public function update(Request $request, $id)
    {
        $leave = Leave::where('employee_id', auth()->id())->findOrFail($id);

        if (!in_array($leave->status, ['pending', 'rejected'])) {
            return back()->with('error', 'Only pending or rejected leave can be updated.');
        }

        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->leave_type === 'Sick Leave' && !$request->hasFile('attachment') && !$leave->attachment_path) {
            return back()->withErrors([
                'attachment' => 'MC attachment is required for Sick Leave.'
            ])->withInput();
        }

        $totalDays = $this->calculateWorkingDays($request->start_date, $request->end_date);

        if ($request->leave_type === 'Annual Leave') {
            $usedAnnualLeave = Leave::where('employee_id', auth()->id())
                ->where('leave_type', 'Annual Leave')
                ->where('status', 'approved')
                ->where('id', '!=', $leave->id)
                ->sum('total_days');

            $remainingBalance = 14 - $usedAnnualLeave;

            if ($totalDays > $remainingBalance) {
                return back()->withErrors([
                    'start_date' => 'Annual leave balance is not enough. Remaining: ' . $remainingBalance . ' days.'
                ])->withInput();
            }
        }

        $attachmentPath = $leave->attachment_path;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        $leave->update([
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
            'remarks' => 'Updated and resubmitted by employee',
        ]);

        return redirect()->route('employee.leaves.index')->with('success', 'Leave updated successfully and resubmitted.');
    }

    public function cancel($id)
    {
        $leave = Leave::where('employee_id', auth()->id())->findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Only pending leave can be cancelled directly.');
        }

        $leave->update([
            'status' => 'cancelled',
            'remarks' => 'Cancelled by employee',
        ]);

        return back()->with('success', 'Leave cancelled successfully.');
    }

    public function requestCancel($id)
    {
        $leave = Leave::where('employee_id', auth()->id())->findOrFail($id);

        if ($leave->status !== 'approved') {
            return back()->with('error', 'Only approved leave can request cancellation.');
        }

        $leave->update([
            'status' => 'cancel_pending',
            'remarks' => 'Cancellation requested by employee',
        ]);

        return back()->with('success', 'Cancellation request submitted to admin.');
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
            return back()->with('error', 'Only pending leave can be approved.');
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
            return back()->with('error', 'Only pending leave can be rejected.');
        }

        $leave->update([
            'status' => 'rejected',
            'remarks' => 'Rejected by admin',
        ]);

        return back()->with('success', 'Leave rejected successfully.');
    }

    public function approveCancel($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave->status !== 'cancel_pending') {
            return back()->with('error', 'Only cancellation requests can be approved.');
        }

        $leave->update([
            'status' => 'cancelled',
            'remarks' => 'Cancellation approved by admin',
        ]);

        return back()->with('success', 'Leave cancellation approved successfully.');
    }

    public function rejectCancel($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave->status !== 'cancel_pending') {
            return back()->with('error', 'Only cancellation requests can be rejected.');
        }

        $leave->update([
            'status' => 'approved',
            'remarks' => 'Cancellation request rejected by admin',
        ]);

        return back()->with('success', 'Leave cancellation request rejected.');
    }

    private function calculateWorkingDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $totalDays = 0;
        $current = $start->copy();

        while ($current->lte($end)) {
            if (!$current->isWeekend()) {
                $totalDays++;
            }
            $current->addDay();
        }

        return $totalDays;
    }
}