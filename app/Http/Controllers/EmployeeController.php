<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeSkill;
use App\Models\EmployeeQualification;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Mail\EmployeeAccountCreated;
use App\Models\AuditLog;
use App\Models\EmploymentRecord;
use App\Models\TransferRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Search for an employee by National ID.
     * Returns search form + result.
     */
    public function search(Request $request)
    {
        $employer = auth()->user()->employer;

        abort_if(!$employer || !$employer->isVerified(), 403, 'Your employer must be verified to use this feature.');

        $employee = null;
        $searched = false;

        if ($request->filled('national_id')) {
            $searched = true;
            $employee = Employee::with([
                'currentEmployer',
                'employmentRecords.employer',
                'pendingTransferRequest',
            ])->where('national_id', $request->national_id)->first();
        }

        return view('employees.search', compact('employee', 'searched', 'employer'));
    }

    /**
     * Show form to register a brand new employee.
     */
    public function create()
    {
        $employer = auth()->user()->employer;
        abort_if(!$employer->isVerified(), 403);

        return view('employees.create', compact('employer'));
    }

    /**
     * Store a new employee and create their user account + first employment record.
     */
    public function store(Request $request)
    {
        $employer = auth()->user()->employer;


        $data = $request->validate([
            'national_id' => 'required',
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender'      => 'required|in:male,female,other',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'required',
            'district'    => 'nullable|string|max:100',
            'province'    => 'nullable|string|max:100',
            'photo'       => 'nullable|image|max:2048',
            'skills'      => 'nullable|string',
            'highest_qualification' => 'nullable|string|max:200',

            'position'    => 'required|string|max:200',
            'department'  => 'nullable|string|max:200',
            'start_date'  => 'required|date',
        ]);

        DB::transaction(function () use ($request, $data, $employer, &$employee, &$user) {

            $tempPassword = Str::random(10);

            // 1. Create user
            $user = User::create([
                'name' => trim($data['first_name'] . ' ' . $data['last_name']),
                'email' => $data['email'],
                'password' => Hash::make($tempPassword),
                'role' => 'employee',
            ]);

            // 2. Upload photo
            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('employees/photos', 'public')
                : null;

            // 3. Create employee
            $employee = Employee::create([
                'user_id' => $user->id,
                'national_id' => $data['national_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'],
                'district' => $data['district'] ?? null,
                'province' => $data['province'] ?? null,
                'photo' => $photoPath,
                'current_employer_id' => $employer->id,
                'status' => 'active',
                'skills' => $data['skills'] ?? null,
                'highest_qualification' => $data['highest_qualification'] ?? null,
            ]);

            // 4. Employment record
            \App\Models\EmploymentRecord::create([
                'employee_id' => $employee->id,
                'employer_id' => $employer->id,
                'position' => $data['position'],
                'department' => $data['department'] ?? null,
                'start_date' => $data['start_date'],
                'status' => 'active',
                'recorded_by' => auth()->id(),
            ]);

            // TODO: send email (recommended via queue)
        });
        return redirect()->route('employees.search')
            ->with('success', 'Employee registered successfully. Login credentials sent to their email.');
    }

    /**
     * View a specific employee's full profile and history (for this employer).
     */
    public function show(Employee $employee)
    {
        $employer = auth()->user()->employer;
        abort_if(!$employer->isVerified(), 403);

        $employee->load([
            'currentemployer',
            'employmentRecords.employer',
            'claims.employmentRecord',
        ]);

        $ownRecord = $employee->employmentRecords->firstWhere('employer_id', $employer->id);

        return view('employees.show', compact('employee', 'employer', 'ownRecord'));
    }

    /**
     * Show form to close/end an employment record (exit).
     */
    public function exitForm(Employee $employee)
    {
        $employer = auth()->user()->employer;
        $record  = EmploymentRecord::where('employee_id', $employee->id)
            ->where('employer_id', $employer->id)
            ->whereNull('end_date')
            ->firstOrFail();

        return view('employees.exit', compact('employee', 'record', 'employer'));
    }

    /**
     * Record exit — close the employment record.
     */
    public function recordExit(Request $request, Employee $employee)
    {
        $employer = auth()->user()->employer;

        $record = EmploymentRecord::where('employee_id', $employee->id)
            ->where('employer_id', $employer->id)
            ->whereNull('end_date')
            ->firstOrFail();

        $data = $request->validate([
            'end_date'            => 'required|date|after_or_equal:' . $record->start_date,
            'exit_reason'         => 'required|in:resigned,terminated,contract_ended,transferred,retired,deceased,redundancy,mutual_agreement,other',
            'exit_details'        => 'nullable|string|max:1000',
            'conduct_rating'      => 'required|in:excellent,good,satisfactory,poor,very_poor',
            'conduct_remarks'     => 'nullable|string|max:2000',
            'eligible_for_rehire' => 'required|boolean',
        ]);

        DB::transaction(function () use ($data, $record, $employee, $employer) {
            $record->update([
                'end_date'            => $data['end_date'],
                'exit_reason'         => $data['exit_reason'],
                'exit_details'        => $data['exit_details'] ?? null,
                'conduct_rating'      => $data['conduct_rating'],
                'conduct_remarks'     => $data['conduct_remarks'] ?? null,
                'eligible_for_rehire' => $data['eligible_for_rehire'],
                'status'              => 'closed',
            ]);

            // Update employee status
            $employee->update([
                'current_employer_id' => null,
                'status'             => 'unemployed',
            ]);
        });

        return redirect()->route('employees.search')
            ->with('success', 'Employment exit recorded successfully.');
    }

    /**
     * Request transfer of an employee from their current employer.
     */
    public function requestTransfer(Request $request, Employee $employee)
    {
        $employer = auth()->user()->employer;
        abort_if(!$employer->isVerified(), 403);

        // Prevent duplicate pending requests
        abort_if($employee->hasPendingTransfer(), 422, 'A transfer request is already pending for this employee.');

        $data = $request->validate([
            'requested_position' => 'required|string|max:200',
            'message'            => 'nullable|string|max:1000',
        ]);

        $transfer = TransferRequest::create([
            'employee_id'           => $employee->id,
            'requesting_employer_id' => $employer->id,
            'current_employer_id'    => $employee->current_employer_id,
            'requested_position'    => $data['requested_position'],
            'message'               => $data['message'] ?? null,
            'status'                => 'pending',
            'requested_by'          => auth()->id(),
        ]);

        // Notify current employer
        $employee->currentemployer->user->notify(new TransferRequested($transfer));

        return back()->with('success', 'Transfer request sent to the current employer. You will be notified when they respond.');
    }

    /**
     * List all employees currently assigned to this 
     */
    public function index()
    {
        $employer   = auth()->user()->employer;

        if (!$employer) {
            return redirect()->route('employer.register');
        }

        if ($employer->verification_status === 'pending') {
            return redirect()->route('employer.pending');
        }

        $employees = Employee::with('employmentRecords')
            ->where('current_employer_id', $employer->id)
            ->latest()
            ->paginate(20);

        return view('employees.index', compact('employees', 'employer'));
    }
}
