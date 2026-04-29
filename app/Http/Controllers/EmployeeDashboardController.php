<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_if(!$user->isEmployee(), 403);

        $employee = $user->employee()->with([
            'currentEmployer',
            'employmentRecords.employer',
            'claims'
        ])->firstOrFail();

        return view('employee.dashboard', compact('employee'));
    }

    public function storeClaim(Request $request)
    {
        $employee = auth()->user()->employee;

        $data = $request->validate([
            'employment_record_id' => 'required|exists:employment_records,id',
            'claim_type' => 'required',
            'description' => 'required|min:10',
            'evidence_file' => 'nullable|file|max:2048'
        ]);

        // secure ownership
        abort_if(
            !$employee->employmentRecords()->where('id', $data['employment_record_id'])->exists(),
            403
        );

        $file = null;
        if ($request->hasFile('evidence_file')) {
            $file = $request->file('evidence_file')->store('claims', 'public');
        }

        Claim::create([
            'employee_id' => $employee->id,
            'employment_record_id' => $data['employment_record_id'],
            'claim_type' => $data['claim_type'],
            'description' => $data['description'],
            'evidence_file' => $file,
        ]);
        return back()->with('success', 'Claim submitted successfully.');
    }

    public function acceptRecord(Request $request)
    {
        $employee = auth()->user()->employee;

        $request->validate([
            'employment_record_id' => 'required|exists:employment_records,id'
        ]);

        // ensure ownership
        abort_if(
            !$employee->employmentRecords()->where('id', $request->employment_record_id)->exists(),
            403
        );

        // you can either store acceptance in DB or log it
        // quick approach: update a column (recommended to add `is_verified_by_employee`)

        \App\Models\EmploymentRecord::where('id', $request->employment_record_id)
            ->update(['employee_verified' => true]);

        return back()->with('success', 'Record confirmed successfully.');
    }

    /**
     * Display employee records
     */
    public function records()
    {
        $user = auth()->user();

        // Ensure only employees access
        abort_if(!$user->isEmployee(), 403);

        $employee = $user->employee()->with([
            'employmentRecords.employer'
        ])->firstOrFail();

        return view('employee.records.index', compact('employee'));
    }

}
