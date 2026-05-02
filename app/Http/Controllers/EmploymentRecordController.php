<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmploymentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploymentRecordController extends Controller
{
    /**
     * Display all employment records for a given employee.
     */
    public function index(Employee $employee)
    {
        $records = $employee->employmentRecords()
            ->with('recordedBy')
            ->latest('start_date')
            ->get();
 
        return view('employment-records.index', compact('employee', 'records'));
    }
 
    /**
     * Store a newly created employment record.
     */
    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'position'            => ['required', 'string', 'max:150'],
            'department'          => ['nullable', 'string', 'max:150'],
            'salary'              => ['required', 'numeric', 'min:0'],
            'status'              => ['required', 'in:active,inactive,suspended'],
            'start_date'          => ['required', 'date'],
            'end_date'            => ['nullable', 'date', 'after_or_equal:start_date'],
            'exit_reason'         => ['nullable', 'in:resigned,terminated,contract_ended,transferred,retired,deceased,redundancy,mutual_agreement,other'],
            'exit_details'        => ['nullable', 'string', 'max:1000'],
            'conduct_rating'      => ['nullable', 'in:excellent,good,satisfactory,poor,very_poor'],
            'conduct_remarks'     => ['nullable', 'string', 'max:1000'],
            'eligible_for_rehire' => ['nullable', 'boolean'],
        ]);
 
        // Enforce: non-active records should have an end date
        if ($validated['status'] !== 'active' && empty($validated['end_date'])) {
            return back()
                ->withErrors(['end_date' => 'An end date is required for non-active records.'])
                ->withInput();
        }
 
        // Active records must not have exit info
        if ($validated['status'] === 'active') {
            $validated['end_date']    = null;
            $validated['exit_reason'] = null;
            $validated['exit_details'] = null;
        }
 
        $employer = Auth::user()->employer;
 
        $employee->employmentRecords()->create([
            ...$validated,
            'employer_id' => $employer->id,
            'recorded_by' => Auth::id(),
        ]);
 
        return redirect()
            ->route('employment-records.index', $employee)
            ->with('success', 'Employment record added successfully.');
    }
 
    /**
     * Show a single employment record.
     */
    public function show(Employee $employee, EmploymentRecord $employmentRecord)
    {
        return view('employment-records.show', compact('employee', 'employmentRecord'));
    }
 
    /**
     * Show the edit form for an employment record.
     */
    public function edit(Employee $employee, EmploymentRecord $employmentRecord)
    {
        return view('employment-records.edit', compact('employee', 'employmentRecord'));
    }
 
    /**
     * Update an existing employment record.
     */
    public function update(Request $request, Employee $employee, EmploymentRecord $employmentRecord)
    {
        $validated = $request->validate([
            'position'            => ['required', 'string', 'max:150'],
            'department'          => ['nullable', 'string', 'max:150'],
            'salary'              => ['required', 'numeric', 'min:0'],
            'status'              => ['required', 'in:active,inactive,suspended'],
            'start_date'          => ['required', 'date'],
            'end_date'            => ['nullable', 'date', 'after_or_equal:start_date'],
            'exit_reason'         => ['nullable', 'in:resigned,terminated,contract_ended,transferred,retired,deceased,redundancy,mutual_agreement,other'],
            'exit_details'        => ['nullable', 'string', 'max:1000'],
            'conduct_rating'      => ['nullable', 'in:excellent,good,satisfactory,poor,very_poor'],
            'conduct_remarks'     => ['nullable', 'string', 'max:1000'],
            'eligible_for_rehire' => ['nullable', 'boolean'],
        ]);
 
        if ($validated['status'] !== 'active' && empty($validated['end_date'])) {
            return back()
                ->withErrors(['end_date' => 'An end date is required for non-active records.'])
                ->withInput();
        }
 
        if ($validated['status'] === 'active') {
            $validated['end_date']     = null;
            $validated['exit_reason']  = null;
            $validated['exit_details'] = null;
        }
 
        $employmentRecord->update($validated);
 
        return redirect()
            ->route('employment-records.index', $employee)
            ->with('success', 'Employment record updated successfully.');
    }
 
    /**
     * Soft-delete an employment record.
     */
    public function destroy(Employee $employee, EmploymentRecord $employmentRecord)
    {
        $employer = Auth::user()->employer;

        abort_unless(
            $employee->employer_id === $employer->id,
            403,
            'You do not have permission to manage this employee.'
        );

        abort_unless(
            $employmentRecord->employee_id === $employee->id,
            404
        );

        $employmentRecord->delete();
 
        return redirect()
            ->route('employment-records.index', $employee)
            ->with('success', 'Employment record deleted.');
    }

}
