<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\EmploymentRecord;
use App\Models\AuditLog;
use App\Http\Requests\StoreEmployerRequest;
use App\Models\Claim;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EmployerController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Show employer dashboard
    public function dashboard()
    {
        $employer = Auth::user()->employer;

        if (! $employer) {
            return redirect()->route('employer.register');
        }

        if ($employer->isPending()) {
            return redirect()
                ->route('employer.pending')
                ->with('info', 'Your account is still under review.');
        }

        if ($employer->isSuspended()) {
            return redirect()
                ->route('employer.pending')
                ->with('error', 'Your account has been suspended. Contact support.');
        }

        // Normal dashboard render — pass whatever stats you need
        $activeRecords = $employer->activeEmploymentRecords()->count();
        $totalEmployees = $employer->currentEmployees()->count();

        return view('employer.dashboard', compact('employer', 'activeRecords', 'totalEmployees'));
    }

    // Show registration form
    public function create()
    {
        $employer = Auth::user()->employer;

        if ($employer) {
            return redirect()->route('employer.dashboard')
                ->with('info', 'Employer profile already exists.');
        }

        return view('employers.register');
    }

    // Store new employer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tin_number' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
            'sector' => 'nullable|string',
            'address' => 'nullable|string',
            'district' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload logo if exists
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('employer-logos', 'public');
        }

        // Auto-fill user_id
        $validated['user_id'] = Auth::id();

        // Default status
        $validated['status'] = 'pending';

        // Create employer
        $employer = Employer::create($validated);

        return redirect()
            ->route('employer.pending')
            ->with('success', 'Employer profile submitted for review.');
    }

    // ── Pending verification page ─────────────────────────────
    public function pending(): View|RedirectResponse
    {
        $user     = Auth::user();
        $employer = $user->employer;

        // If the user has no employer profile yet, send them to register
        if (! $employer) {
            return redirect()
                ->route('employer.register')
                ->with('info', 'Please complete your employer registration first.');
        }

        // If already verified and active, redirect to dashboard
        if ($employer->isVerified() && $user->is_active) {
            return redirect()
                ->route('employer.dashboard')
                ->with('success', 'Your account is now active!');
        }

        return view('employer.pending', compact('employer'));
    }

    // Report new employee hire
    public function reportEmployment(Request $request)
    {
        $employer = Auth::user()->employer;

        $validated = $request->validate([
            'national_id'      => 'required|string|exists:employees,national_id',
            'job_title'        => 'required|string|max:150',
            'department'       => 'nullable|string|max:100',
            'employment_type'  => 'required|in:full_time,part_time,contract,internship,volunteer,attachment',
            'start_date'       => 'required|date|before_or_equal:today',
            'salary_start'     => 'nullable|numeric|min:0',
            'salary_currency'  => 'nullable|string|max:10',
            'job_description'  => 'nullable|string|max:2000',
        ]);

        $employee = \App\Models\Employee::where('national_id', $validated['national_id'])
            ->firstOrFail();

        // Check for existing active record
        $exists = EmploymentRecord::where('employee_id', $employee->id)
            ->where('employer_id', $employer->id)
            ->where('is_current', true)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This employee already has an active record with your organization.');
        }

        EmploymentRecord::create([
            ...$validated,
            'employee_id'          => $employee->id,
            'employer_id'          => $employer->id,
            'is_current'           => true,
            'record_source'        => 'employer_reported',
            'employer_verified'    => true,
            'employer_verified_at' => now(),
        ]);

        // Update employee status
        $employee->update([
            'employment_status' => 'employed',
            'current_job_title' => $validated['job_title'],
        ]);

        AuditLog::record(
            'created',
            "Employment record created for {$employee->full_name}",
            $employee
        );

        return back()->with('success', "Employment record created for {$employee->full_name}.");
    }

    // Report employee exit
    public function reportExit(Request $request, EmploymentRecord $record)
    {
        $validated = $request->validate([
            'end_date'              => 'required|date|after_or_equal:' . $record->start_date->toDateString(),
            'exit_reason'           => 'required|in:resignation,contract_expiry,mutual_agreement,redundancy,dismissal_misconduct,dismissal_performance,medical_grounds,retirement,death,other',
            'exit_details'          => 'required_if:exit_reason,dismissal_misconduct,dismissal_performance|nullable|string|max:3000',
            'exit_reference_number' => 'nullable|string|max:100',
        ]);

        $record->update([
            ...$validated,
            'is_current' => false,
        ]);

        // Update employee status if no other active employment
        $employee     = $record->employee;
        $stillEmployed = EmploymentRecord::where('employee_id', $employee->id)
            ->where('is_current', true)
            ->exists();

        if (! $stillEmployed) {
            $employee->update([
                'employment_status' => 'unemployed',
                'current_job_title' => null,
            ]);
        }

        AuditLog::record(
            'updated',
            "Exit recorded for {$employee->full_name}",
            $record
        );

        return back()->with('success', 'Exit record submitted. You may now submit professional feedback.');
    }
}
