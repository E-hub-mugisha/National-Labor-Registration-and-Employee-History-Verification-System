<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\VerificationRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Show search portal
    public function index()
    {
        $employer = Auth::user()->employer;

        if (! $employer) {
            return redirect()->route('employer.register');
        }

        $recentSearches = VerificationRequest::where('employer_id', $employer->id)
            ->with('employee')
            ->latest('searched_at')
            ->take(10)
            ->get();

        return view('verification.index', compact('employer', 'recentSearches'));
    }

    // Search employee by National ID
    public function search(Request $request)
    {
        $employer = Auth::user()->employer()->first();

        if (!$employer || $employer->verification_status !== 'verified') {
            return back()->with('error', 'Your account is not verified.');
        }

        if (!$employer->canSearch()) {
            return back()->with('error', 'Monthly search quota exhausted.');
        }

        $request->validate([
            'national_id' => 'required|string',
            'purpose'     => 'required|in:pre_employment_check,background_verification,contract_renewal,security_clearance,other',
        ]);

        $employee = \App\Models\Employee::where('national_id', $request->national_id)
            ->where('is_searchable', true)
            ->first();

        // Always create log with searched_at set to now()
        $log = \App\Models\VerificationRequest::create([
            'employer_id'          => $employer->id,
            'requested_by'         => Auth::id(),
            'national_id_queried'  => $request->national_id,
            'purpose'              => $request->purpose,
            'position_applied_for' => $request->position_applied_for ?? null,
            'employee_id'          => $employee?->id ?? null,
            'employee_found'       => $employee ? true : false,
            'data_returned'        => $employee ? $this->buildSnapshot($employee) : null,
            'ip_address'           => $request->ip(),
            'searched_at'          => now(),
        ]);

        $employer->incrementSearchCount();

        \App\Models\AuditLog::record(
            'searched',
            "Employer {$employer->display_name} searched for {$request->national_id}",
            $employer
        );

        if (!$employee) {
            return view('verification.not-found', [
                'nationalId' => $request->national_id,
                'log'        => $log,
            ]);
        }

        return view('verification.result', [
            'employee' => $employee,
            'log'      => $log,
        ]);
    }

    // Show detailed employee profile
    public function show(\App\Models\Employee $employee)
    {
        $employer = Auth::user()->employer()->first();

        if (!$employer || $employer->verification_status !== 'verified') {
            return redirect()->route('employer.verify.index')
                ->with('error', 'Your account is not verified.');
        }

        // Get most recent search log for this employee by this employer
        $log = \App\Models\VerificationRequest::where('employer_id', $employer->id)
            ->where('employee_id', $employee->id)
            ->latest('searched_at')
            ->first();

        // If no log found create a fresh one
        if (!$log) {
            $log = \App\Models\VerificationRequest::create([
                'employer_id'          => $employer->id,
                'requested_by'         => Auth::id(),
                'national_id_queried'  => $employee->national_id,
                'purpose'              => 'background_verification',
                'position_applied_for' => null,
                'employee_id'          => $employee->id,
                'employee_found'       => true,
                'data_returned'        => $this->buildSnapshot($employee),
                'ip_address'           => request()->ip(),
                'searched_at'          => now(),
            ]);
        }

        // Make sure searched_at is never null
        if (!$log->searched_at) {
            $log->searched_at = now();
            $log->save();
        }

        return view('verification.result', [
            'employee' => $employee,
            'log'      => $log,
        ]);
    }

    // Build data snapshot for audit trail
    private function buildSnapshot(\App\Models\Employee $employee): array
    {
        return [
            'name'              => $employee->full_name,
            'national_id'       => $employee->national_id,
            'employment_status' => $employee->employment_status,
            'nida_verified'     => $employee->nida_verified,
            'total_records'     => $employee->employmentRecords->count(),
            'snapshot_at'       => now()->toDateTimeString(),
        ];
    }
}
