<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Claim;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\EmploymentRecord;
use App\Models\TransferRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ── Admin Dashboard ───────────────────────────────────────────────────────

    public function admin()
    {
        $user = Auth::user();

        // ── Headline KPIs ──────────────────────────────────────────────────
        $totalEmployees   = Employee::count();
        $activeEmployees  = Employee::active()->count();
        $totalEmployers   = Employer::count();
        $verifiedEmployers = Employer::verified()->count();
        $pendingEmployers  = Employer::pending()->count();
        $totalRecords     = EmploymentRecord::count();
        $openClaims       = Claim::where('status', 'pending')->orWhere('status', 'under_review')->count();
        $pendingTransfers = TransferRequest::pending()->count();

        // ── Month-over-month growth ────────────────────────────────────────
        $employeeGrowth = $this->growthRate(Employee::class);
        $employerGrowth = $this->growthRate(Employer::class);

        // ── Employee status breakdown ──────────────────────────────────────
        $employeeStatusBreakdown = Employee::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // ── Employer sector distribution ───────────────────────────────────
        $sectorDistribution = Employer::select('sector', DB::raw('count(*) as total'))
            ->groupBy('sector')
            ->orderByDesc('total')
            ->get()
            ->map(fn($r) => [
                'sector' => $r->sector_label,
                'total'  => $r->total,
            ]);

        // ── Monthly new registrations (last 12 months) ─────────────────────
        $monthlyEmployees = Employee::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyEmployers = Employer::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Fill all 12 month slots
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }
        $chartMonths    = $months->map(fn($m) => now()->createFromFormat('Y-m', $m)->format('M Y'))->values();
        $chartEmployees = $months->map(fn($m) => $monthlyEmployees[$m] ?? 0)->values();
        $chartEmployers = $months->map(fn($m) => $monthlyEmployers[$m] ?? 0)->values();

        // ── Claims breakdown ───────────────────────────────────────────────
        $claimsBreakdown = Claim::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // ── Exit reason breakdown ──────────────────────────────────────────
        $exitReasons = EmploymentRecord::whereNotNull('exit_reason')
            ->select('exit_reason', DB::raw('count(*) as total'))
            ->groupBy('exit_reason')
            ->orderByDesc('total')
            ->get();

        // ── Transfer request stats ─────────────────────────────────────────
        $transferStats = TransferRequest::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // ── Recent audit logs ──────────────────────────────────────────────
        $recentLogs = AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // ── Blacklisted employees ──────────────────────────────────────────
        $blacklistedCount = Employee::where('status', 'blacklisted')->count();

        // ── Province distribution ──────────────────────────────────────────
        $provinceDistribution = Employee::select('province', DB::raw('count(*) as total'))
            ->groupBy('province')
            ->orderByDesc('total')
            ->get();

        // ── Top employers by headcount ─────────────────────────────────────
        $topEmployers = Employer::withCount('currentEmployees')
            ->orderByDesc('current_employees_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'user',
            'totalEmployees', 'activeEmployees', 'employeeGrowth',
            'totalEmployers', 'verifiedEmployers', 'pendingEmployers', 'employerGrowth',
            'totalRecords', 'openClaims', 'pendingTransfers',
            'employeeStatusBreakdown', 'sectorDistribution',
            'chartMonths', 'chartEmployees', 'chartEmployers',
            'claimsBreakdown', 'exitReasons', 'transferStats',
            'recentLogs', 'blacklistedCount', 'provinceDistribution', 'topEmployers'
        ));
    }

    // ── Employer Dashboard ────────────────────────────────────────────────────

    public function employer()
    {
        $user     = Auth::user();
        $employer = $user->employer;

        if (! $employer) {
            return redirect()->route('employer.profile.create')
                ->with('info', 'Please complete your employer profile first.');
        }

        // ── Headline KPIs ──────────────────────────────────────────────────
        $totalEmployees   = $employer->currentEmployees()->count();
        $activeRecords    = $employer->activeEmploymentRecords()->count();
        $pendingTransfers = $employer->transferRequestsReceived()->pending()->count();
        $sentTransfers    = $employer->transferRequestsSent()->pending()->count();

        // ── Conduct rating distribution of current staff ───────────────────
        $conductBreakdown = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNull('end_date')
            ->select('conduct_rating', DB::raw('count(*) as total'))
            ->groupBy('conduct_rating')
            ->pluck('total', 'conduct_rating')
            ->toArray();

        // ── Department headcount ───────────────────────────────────────────
        $departmentBreakdown = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNull('end_date')
            ->whereNotNull('department')
            ->select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        // ── Monthly hiring trend (last 12 months) ─────────────────────────
        $monthlyHiring = EmploymentRecord::where('employer_id', $employer->id)
            ->where('start_date', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(start_date, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }
        $chartMonths  = $months->map(fn($m) => now()->createFromFormat('Y-m', $m)->format('M Y'))->values();
        $chartHiring  = $months->map(fn($m) => $monthlyHiring[$m] ?? 0)->values();

        // ── Monthly exits (last 12 months) ────────────────────────────────
        $monthlyExits = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNotNull('end_date')
            ->where('end_date', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(end_date, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
        $chartExits = $months->map(fn($m) => $monthlyExits[$m] ?? 0)->values();

        // ── Exit reason breakdown ──────────────────────────────────────────
        $exitReasons = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNotNull('exit_reason')
            ->select('exit_reason', DB::raw('count(*) as total'))
            ->groupBy('exit_reason')
            ->orderByDesc('total')
            ->get();

        // ── Rehire eligibility ─────────────────────────────────────────────
        $rehireEligible = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNotNull('end_date')
            ->where('eligible_for_rehire', true)
            ->count();

        $rehireIneligible = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNotNull('end_date')
            ->where('eligible_for_rehire', false)
            ->count();

        // ── Recent transfer requests received ──────────────────────────────
        $recentTransfers = $employer->transferRequestsReceived()
            ->with(['employee', 'requestingEmployer'])
            ->latest()
            ->take(5)
            ->get();

        // ── Recent employees hired ─────────────────────────────────────────
        $recentHires = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNull('end_date')
            ->with('employee')
            ->latest('start_date')
            ->take(5)
            ->get();

        // ── Avg salary ────────────────────────────────────────────────────
        $avgSalary = EmploymentRecord::where('employer_id', $employer->id)
            ->whereNull('end_date')
            ->whereNotNull('salary')
            ->avg('salary');

        // ── Claims filed against this employer's records ───────────────────
        $claimsAgainst = Claim::whereHas('employmentRecord', fn($q) => $q->where('employer_id', $employer->id))
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('employers.dashboard', compact(
            'user', 'employer',
            'totalEmployees', 'activeRecords', 'pendingTransfers', 'sentTransfers',
            'conductBreakdown', 'departmentBreakdown',
            'chartMonths', 'chartHiring', 'chartExits',
            'exitReasons', 'rehireEligible', 'rehireIneligible',
            'recentTransfers', 'recentHires', 'avgSalary', 'claimsAgainst'
        ));
    }

    // ── Employee Dashboard ────────────────────────────────────────────────────

    public function employee()
    {
        $user     = Auth::user();
        $employee = $user->employee;

        if (! $employee) {
            return redirect()->route('employee.profile.create')
                ->with('info', 'Please complete your profile first.');
        }

        // ── Current employment ─────────────────────────────────────────────
        $currentRecord  = $employee->activeEmploymentRecord;
        $currentEmployer = $employee->currentEmployer;

        // ── Employment history ─────────────────────────────────────────────
        $totalJobs        = $employee->employmentRecords()->count();
        $employmentHistory = $employee->employmentRecords()
            ->with('employer')
            ->get();

        // ── Total tenure (days across all jobs) ───────────────────────────
        $totalDays = $employmentHistory->sum(function ($r) {
            $end = $r->end_date ?? now();
            return $r->start_date->diffInDays($end);
        });
        $totalYears  = floor($totalDays / 365);
        $totalMonths = floor(($totalDays % 365) / 30);

        // ── Claims ────────────────────────────────────────────────────────
        $totalClaims    = $employee->claims()->count();
        $pendingClaims  = $employee->claims()->where('status', 'pending')->count();
        $resolvedClaims = $employee->claims()->where('status', 'resolved')->count();
        $recentClaims   = $employee->claims()->with('employmentRecord.employer')->latest()->take(5)->get();

        // ── Transfer requests ─────────────────────────────────────────────
        $pendingTransfer  = $employee->pendingTransferRequest;
        $totalTransfers   = $employee->transferRequests()->count();
        $approvedTransfers = $employee->transferRequests()->approved()->count();

        // ── Conduct summary ────────────────────────────────────────────────
        $conductSummary = $employmentHistory
            ->whereNotNull('conduct_rating')
            ->groupBy('conduct_rating')
            ->map->count();

        // ── Career timeline data for chart ────────────────────────────────
        $timeline = $employmentHistory->map(fn($r) => [
            'employer'   => $r->employer->name ?? 'Unknown',
            'position'   => $r->position,
            'start'      => $r->start_date->format('M Y'),
            'end'        => $r->end_date ? $r->end_date->format('M Y') : 'Present',
            'duration'   => $r->duration,
            'conduct'    => $r->conduct_rating,
            'is_active'  => $r->is_active,
        ])->values();

        // ── Province / skills ──────────────────────────────────────────────
        $skills = $employee->skills
            ? (is_array($employee->skills) ? $employee->skills : explode(',', $employee->skills))
            : [];

        return view('employees.dashboard', compact(
            'user', 'employee',
            'currentRecord', 'currentEmployer',
            'totalJobs', 'employmentHistory',
            'totalYears', 'totalMonths',
            'totalClaims', 'pendingClaims', 'resolvedClaims', 'recentClaims',
            'pendingTransfer', 'totalTransfers', 'approvedTransfers',
            'conductSummary', 'timeline', 'skills'
        ));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function growthRate(string $model): float
    {
        $thisMonth = $model::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonth = $model::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($lastMonth === 0) return $thisMonth > 0 ? 100.0 : 0.0;

        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1);
    }
}