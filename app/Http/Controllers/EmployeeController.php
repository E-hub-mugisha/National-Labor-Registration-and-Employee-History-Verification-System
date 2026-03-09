<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeSkill;
use App\Models\EmployeeQualification;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Show employee dashboard
    public function dashboard()
    {
        $employee = Auth::user()->employee;

        if (! $employee) {
            return redirect()->route('employee.register');
        }

        $employee->load([
            'employmentRecords.employer',
            'employmentRecords.feedback',
            'skills',
            'qualifications',
        ]);

        $stats = [
            'total_experience' => round($employee->total_experience_years, 1),
            'total_employers'  => $employee->employmentRecords->count(),
            'verified_records' => $employee->employmentRecords
                ->where('employer_verified', true)
                ->count(),
            'avg_rating'       => $employee->average_rating,
            'profile_views'    => $employee->verificationRequests->count(),
        ];

        return view('employees.dashboard', compact('employee', 'stats'));
    }

    // Show registration form
    public function create()
    {
        if (Auth::user()->employee) {
            return redirect()->route('employee.dashboard')
                ->with('info', 'Profile already created.');
        }

        return view('employees.register');
    }

    // Store new employee profile
    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::create([
                ...$request->validated(),
                'user_id'          => Auth::id(),
                'nida_verified'    => false,
                'profile_complete' => false,
            ]);

            DB::commit();

            AuditLog::record(
                'created',
                'Employee profile created',
                $employee
            );

            return redirect()->route('employee.profile.edit', $employee)
                ->with('success', 'Profile created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Employee registration failed: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    // Show edit profile form
    public function edit()
    {
        $employee = Auth::user()->employee;

        if (! $employee) {
            return redirect()->route('employee.register');
        }

        $employee->load(['skills', 'qualifications', 'employmentRecords']);

        return view('employees.edit', compact('employee'));
    }

    // Update employee profile
    public function update(UpdateEmployeeRequest $request)
    {
        $employee = Auth::user()->employee;

        $employee->update($request->validated());
        $employee->update([
            'profile_complete' => $this->checkProfileComplete($employee)
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    // Add a skill
    public function addSkill(Request $request)
    {
        $employee = Auth::user()->employee;

        $validated = $request->validate([
            'skill_name'          => 'required|string|max:100',
            'proficiency_level'   => 'required|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'required|integer|min:0|max:50',
        ]);

        $employee->skills()->create($validated);

        return back()->with('success', 'Skill added successfully.');
    }

    // Delete a skill
    public function deleteSkill(EmployeeSkill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill removed.');
    }

    // Add a qualification
    public function addQualification(Request $request)
    {
        $employee = Auth::user()->employee;

        $validated = $request->validate([
            'type'                 => 'required|in:academic,professional,vocational,certification,other',
            'institution_name'     => 'required|string|max:200',
            'qualification_title'  => 'required|string|max:200',
            'field_of_study'       => 'nullable|string|max:100',
            'start_date'           => 'nullable|date',
            'end_date'             => 'nullable|date|after_or_equal:start_date',
            'is_current'           => 'boolean',
            'certificate_number'   => 'nullable|string|max:100',
        ]);

        $employee->qualifications()->create($validated);

        return back()->with('success', 'Qualification added successfully.');
    }

    // Toggle profile visibility
    public function toggleSearchable()
    {
        $employee = Auth::user()->employee;
        $employee->update(['is_searchable' => ! $employee->is_searchable]);

        $status = $employee->is_searchable ? 'visible' : 'hidden';

        return back()->with('success', "Your profile is now {$status} in search results.");
    }

    // Check if profile is complete
    private function checkProfileComplete(Employee $employee): bool
    {
        return filled($employee->first_name)
            && filled($employee->last_name)
            && filled($employee->national_id)
            && filled($employee->phone_primary)
            && filled($employee->employment_status)
            && $employee->skills()->exists();
    }

    public function profile()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('employee.register');
        }

        return view('employees.profile', compact('employee'));
    }
}
