<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\EmploymentRecord;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    // ── Shared helper: resolve authenticated employee with eager loads ──────────

    /**
     * Returns the Employee model for the currently authenticated user,
     * with all relationships needed across the dashboard pre-loaded.
     * Aborts with 403 if the user is not an employee.
     */
    private function resolveEmployee(array $extraWith = [])
    {
        $user = auth()->user();

        abort_if(!$user->isEmployee(), 403);

        $defaultWith = [
            'currentEmployer',
            'activeEmploymentRecord',
            'pendingTransferRequest',
            'employmentRecords.employer',
            'claims',
        ];

        return $user->employee()
            ->with(array_unique(array_merge($defaultWith, $extraWith)))
            ->firstOrFail();
    }

    // ── Dashboard index ────────────────────────────────────────────────────────

    public function index()
    {
        $employee = $this->resolveEmployee();

        return view('employee.dashboard', compact('employee'));
    }

    // ── Employment records list ────────────────────────────────────────────────

    public function records()
    {
        $employee = auth()->user()->employee;
        $employmentRecords = EmploymentRecord::where('employee_id', $employee->id)->get();

        return view('employees.records.index', compact('employee', 'employmentRecords'));
    }

    // ── Accept / verify an employment record ──────────────────────────────────

    public function acceptRecord(Request $request)
    {
        $employee = auth()->user()->employee;

        $request->validate([
            'employment_record_id' => 'required|exists:employment_records,id',
        ]);

        // Ownership check — employee may only touch their own records
        abort_if(
            !$employee->employmentRecords()
                ->where('id', $request->employment_record_id)
                ->exists(),
            403
        );

        EmploymentRecord::where('id', $request->employment_record_id)
            ->update(['employee_verified' => true]);

        return back()->with('success', 'Record confirmed successfully.');
    }

    // ── Store a new claim ──────────────────────────────────────────────────────

    public function storeClaim(Request $request)
    {
        $employee = auth()->user()->employee;

        $data = $request->validate([
            'employment_record_id' => 'required|exists:employment_records,id',
            'claim_type'           => 'required|string',
            'description'          => 'required|string|min:10',
            'evidence_file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Ownership check — employee may only claim their own records
        abort_if(
            !$employee->employmentRecords()
                ->where('id', $data['employment_record_id'])
                ->exists(),
            403
        );

        $filePath = null;
        if ($request->hasFile('evidence_file')) {
            $filePath = $request->file('evidence_file')
                ->store('claims', 'public');
        }

        Claim::create([
            'employee_id'          => $employee->id,
            'employment_record_id' => $data['employment_record_id'],
            'claim_type'           => $data['claim_type'],
            'description'          => $data['description'],
            'evidence_file'        => $filePath,
            'status'               => 'pending',   // FIXED: was missing, left status null
        ]);

        return back()->with('success', 'Claim submitted successfully.');
    }
}
