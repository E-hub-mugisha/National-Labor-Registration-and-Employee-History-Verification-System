<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\EmploymentRecord;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GovernmentController extends Controller
{
    public function employers()
    {
        $employers = Employer::latest()->paginate(20);
        return view('gov.employers.index', compact('employers'));
    }

    public function verifyEmployer($id)
    {
        $employer = Employer::findOrFail($id);
        $employer->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        return back()->with('success', 'Employer verified');
    }

    public function rejectEmployer(Request $request, $id)
    {
        $employer = Employer::findOrFail($id);

        $employer->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        return back()->with('success', 'Employer rejected');
    }

    public function suspendEmployer($id)
    {
        Employer::findOrFail($id)->update([
            'status' => 'suspended'
        ]);

        return back()->with('success', 'Employer suspended');
    }

    public function employeeHistory($id)
    {
        $employee = Employee::with([
            'employmentRecords.employer'
        ])->findOrFail($id);

        return view('gov.employees.history', compact('employee'));
    }

    public function employees(Request $request)
    {
        $query = Employee::with('currentEmployer');

        if ($request->search) {
            $query->where('national_id', $request->search)
                ->orWhere('email', $request->search)
                ->orWhere('phone', $request->search);
        }

        $employees = $query->paginate(20);

        return view('gov.employees.index', compact('employees'));
    }

    public function transfers()
    {
        $transfers = TransferRequest::with(['employee', 'fromEmployer', 'toEmployer'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('gov.transfers.index', compact('transfers'));
    }

    public function approveTransfer($id)
    {
        DB::transaction(function () use ($id) {

            $transfer = TransferRequest::findOrFail($id);

            $employee = Employee::find($transfer->employee_id);

            // update employee
            $employee->update([
                'current_employer_id' => $transfer->to_employer_id
            ]);

            // close old employment
            EmploymentRecord::where('employee_id', $employee->id)
                ->whereNull('end_date')
                ->update(['end_date' => now()]);

            // create new record
            EmploymentRecord::create([
                'employee_id' => $employee->id,
                'employer_id' => $transfer->to_employer_id,
                'position' => 'Transferred',
                'start_date' => now(),
                'status' => 'active',
                'recorded_by' => auth()->id(),
            ]);

            $transfer->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
        });

        return back()->with('success', 'Transfer approved');
    }

    public function rejectTransfer($id)
    {
        TransferRequest::findOrFail($id)->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Transfer rejected');
    }

    public function claims()
    {
        $claims = Claim::with('employee')->latest()->paginate(20);

        return view('gov.claims.index', compact('claims'));
    }

    public function resolveClaim(Request $request, $id)
    {
        $claim = Claim::findOrFail($id);

        $claim->update([
            'status' => 'resolved',
            'admin_response' => $request->response
        ]);

        return back()->with('success', 'Claim resolved');
    }

    public function dashboard()
    {
        return view('gov.dashboard', [
            'total_employers' => Employer::count(),
            'verified_employers' => Employer::where('status', 'verified')->count(),
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'pending_transfers' => TransferRequest::where('status', 'pending')->count(),
            'pending_claims' => Claim::where('status', 'pending')->count(),
        ]);
    }
}
