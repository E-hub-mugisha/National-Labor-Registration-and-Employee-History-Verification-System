<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Employee;
use App\Models\ProfessionalFeedback;
use App\Models\EmploymentRecord;
use App\Models\VerificationRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Admin dashboard
    public function dashboard()
    {
        $stats = [
            'total_employees'     => Employee::count(),
            'verified_employees'  => Employee::where('nida_verified', true)->count(),
            'total_employers'     => Employer::count(),
            'pending_employers'   => Employer::where('verification_status', 'pending')->count(),
            'verified_employers'  => Employer::where('verification_status', 'verified')->count(),
            'total_records'       => EmploymentRecord::count(),
            'total_feedback'      => ProfessionalFeedback::count(),
            'pending_moderation'  => ProfessionalFeedback::where('moderation_status', 'pending')->count(),
            'searches_today'      => VerificationRequest::whereDate('searched_at', today())->count(),
            'searches_this_month' => VerificationRequest::whereMonth('searched_at', now()->month)->count(),
        ];

        $pendingEmployers = Employer::where('verification_status', 'pending')
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        $pendingFeedback = ProfessionalFeedback::where('moderation_status', 'pending')
            ->with(['employee', 'employer'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingEmployers', 'pendingFeedback'));
    }

    // List all employers
    public function employers()
    {
        $employers = Employer::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.employers.index', compact('employers'));
    }

    // Verify or reject employer
    public function verifyEmployer(Request $request, Employer $employer)
    {
        $request->validate([
            'action'           => 'required|in:verify,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string|max:1000',
        ]);

        if ($request->action === 'verify') {
            $employer->update([
                'verification_status' => 'verified',
                'verified_at'         => now(),
                'verified_by'         => Auth::id(),
            ]);
            $status = 'verified';
        } else {
            $employer->update([
                'verification_status' => 'rejected',
                'rejection_reason'    => $request->rejection_reason,
            ]);
            $status = 'rejected';
        }

        AuditLog::record(
            $status,
            "Employer {$employer->company_name} {$status}",
            $employer
        );

        return back()->with('success', "Employer has been {$status}.");
    }

    // List all employees
    public function employees()
    {
        $employees = Employee::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    // Verify employee National ID
    public function verifyEmployee(Request $request, \App\Models\Employee $employee)
    {
        $request->validate([
            'action' => 'required|in:verify,unverify',
        ]);

        if ($request->action === 'verify') {
            $employee->update([
                'nida_verified'         => true,
                'nida_verified_at'      => now(),
                'nida_verification_ref' => 'NIDA-ADMIN-' . strtoupper(substr(md5($employee->national_id), 0, 8)),
                'profile_complete'      => true,
                'is_searchable'         => true,
            ]);
            $status = 'verified';
        } else {
            $employee->update([
                'nida_verified'         => false,
                'nida_verified_at'      => null,
                'nida_verification_ref' => null,
                'profile_complete'      => false,
            ]);
            $status = 'unverified';
        }

        AuditLog::record(
            'verified',
            "Employee {$employee->full_name} {$status} by admin",
            $employee
        );

        return back()->with('success', "Employee {$employee->full_name} has been {$status}.");
    }

    // List feedback pending moderation
    public function feedback()
    {
        $feedback = ProfessionalFeedback::where('moderation_status', 'pending')
            ->with(['employee', 'employer', 'submittedBy'])
            ->latest()
            ->paginate(15);

        return view('admin.feedback.index', compact('feedback'));
    }

    // Approve or reject feedback
    public function moderateFeedback(Request $request, ProfessionalFeedback $feedback)
    {
        $request->validate([
            'action'           => 'required|in:approve,flag,remove',
            'moderation_notes' => 'nullable|string|max:1000',
        ]);

        $statusMap = [
            'approve' => 'approved',
            'flag'    => 'flagged',
            'remove'  => 'removed',
        ];

        $feedback->update([
            'moderation_status' => $statusMap[$request->action],
            'moderated_by'      => Auth::id(),
            'moderated_at'      => now(),
            'moderation_notes'  => $request->moderation_notes,
            'is_published'      => $request->action === 'approve',
            'published_at'      => $request->action === 'approve' ? now() : null,
        ]);

        AuditLog::record(
            'moderated',
            "Feedback {$statusMap[$request->action]}",
            $feedback
        );

        return back()->with('success', "Feedback {$statusMap[$request->action]} successfully.");
    }

    // Audit log viewer
    public function auditLog()
    {
        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.audit-log', compact('logs'));
    }

    // Labor market statistics
    public function statistics()
    {
        $employmentByStatus = Employee::groupBy('employment_status')
            ->selectRaw('employment_status, count(*) as count')
            ->pluck('count', 'employment_status');

        $employmentByDistrict = Employee::groupBy('district')
            ->selectRaw('district, count(*) as count')
            ->orderByDesc('count')
            ->take(10)
            ->pluck('count', 'district');

        $topIndustries = Employer::where('verification_status', 'verified')
            ->groupBy('industry_sector')
            ->selectRaw('industry_sector, count(*) as count')
            ->orderByDesc('count')
            ->take(10)
            ->pluck('count', 'industry_sector');

        $exitReasons = EmploymentRecord::whereNotNull('exit_reason')
            ->groupBy('exit_reason')
            ->selectRaw('exit_reason, count(*) as count')
            ->pluck('count', 'exit_reason');

        $monthlyRegistrations = Employee::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->pluck('count', 'month');

        return view('admin.statistics', compact(
            'employmentByStatus',
            'employmentByDistrict',
            'topIndustries',
            'exitReasons',
            'monthlyRegistrations'
        ));
    }
}
