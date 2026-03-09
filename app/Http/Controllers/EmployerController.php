<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\EmploymentRecord;
use App\Models\AuditLog;
use App\Http\Requests\StoreEmployerRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        if (!$employer) {
            return redirect()->route('employer.register');
        }

        if ($employer->verification_status === 'pending') {
            return redirect()->route('employer.pending');
        }

        $recentRecords = \App\Models\EmploymentRecord::where('employer_id', $employer->id)
            ->with(['employee'])
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'active_employees'    => \App\Models\EmploymentRecord::where('employer_id', $employer->id)
                ->where('is_current', true)->count(),
            'total_records'       => \App\Models\EmploymentRecord::where('employer_id', $employer->id)->count(),
            'searches_this_month' => \App\Models\VerificationRequest::where('employer_id', $employer->id)
                ->whereMonth('searched_at', now()->month)->count(),
            'searches_remaining'  => $employer->remaining_search_quota,
        ];

        return view('employers.dashboard', compact('employer', 'recentRecords', 'stats'));
    }

    // Show registration form
    public function create()
    {
        $employer = Auth::user()->employer()->first();

        if ($employer) {
            return redirect()->route('employer.dashboard')
                ->with('info', 'Employer profile already exists.');
        }

        return view('employers.register');
    }

    // Store new employer
    public function store(StoreEmployerRequest $request)
    {
        DB::beginTransaction();
        try {
            $employer = Employer::create([
                ...$request->validated(),
                'user_id'              => Auth::id(),
                'verification_status'  => 'pending',
                'monthly_search_quota' => 50,
                'quota_reset_date'     => now()->addMonth()->startOfMonth(),
            ]);

            if ($request->hasFile('company_logo')) {
                $employer->update([
                    'company_logo' => $request->file('company_logo')
                        ->store("logos/{$employer->id}", 'public'),
                ]);
            }

            DB::commit();

            AuditLog::record(
                'created',
                'Employer profile created',
                $employer
            );

            return redirect()->route('employer.pending')
                ->with('success', 'Registration submitted. Awaiting verification.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Employer registration failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
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

    // Pending verification page
    public function pending()
    {
        return view('employers.pending');
    }
}
