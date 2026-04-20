<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::where('employee_id', auth()->id())->latest()->get();
        return view('employee.claims.index', compact('claims'));
    }

    public function create()
    {
        return view('employee.claims.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'receipt_upload' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = null;

        if ($request->hasFile('receipt_upload')) {
            $path = $request->file('receipt_upload')->store('claim_receipts', 'public');
        }

        Claim::create([
            'employee_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'receipt_upload' => $path,
            'status' => 'Submitted',
            'remarks' => null,
        ]);

        return redirect()->route('employee.claims.index')->with('success', 'Claim submitted successfully.');
    }

    public function adminIndex()
    {
        $claims = Claim::with('employee')->latest()->get();
        return view('admin.claims.index', compact('claims'));
    }

    public function approve($id)
    {
        $claim = Claim::findOrFail($id);

        if ($claim->status !== 'Submitted') {
            return back()->with('success', 'This claim has already been processed.');
        }

        $claim->update([
            'status' => 'Approved',
            'remarks' => 'Approved by admin',
        ]);

        return back()->with('success', 'Claim approved successfully.');
    }

    public function reject($id)
    {
        $claim = Claim::findOrFail($id);

        if ($claim->status !== 'Submitted') {
            return back()->with('success', 'This claim has already been processed.');
        }

        $claim->update([
            'status' => 'Rejected',
            'remarks' => 'Rejected by admin',
        ]);

        return back()->with('success', 'Claim rejected successfully.');
    }
}