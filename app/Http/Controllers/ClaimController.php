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
            'claim_type' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'claim_date' => 'required|date',
            'description' => 'nullable|string',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $receiptPath = null;

        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('claim_receipts', 'public');
        }

        Claim::create([
            'employee_id' => auth()->id(),
            'claim_type' => $request->claim_type,
            'amount' => $request->amount,
            'claim_date' => $request->claim_date,
            'description' => $request->description,
            'receipt_path' => $receiptPath,
            'status' => 'pending',
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

        if ($claim->status !== 'pending') {
            return back()->with('success', 'This claim has already been processed.');
        }

        $claim->update([
            'status' => 'approved',
            'remarks' => 'Approved by admin',
        ]);

        return back()->with('success', 'Claim approved successfully.');
    }

    public function reject($id)
    {
        $claim = Claim::findOrFail($id);

        if ($claim->status !== 'pending') {
            return back()->with('success', 'This claim has already been processed.');
        }

        $claim->update([
            'status' => 'rejected',
            'remarks' => 'Rejected by admin',
        ]);

        return back()->with('success', 'Claim rejected successfully.');
    }
}