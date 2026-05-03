@extends('layouts.app')

@section('title', 'Gov Dashboard')

@section('content')

<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Government Portal</li>
            </ol>
        </nav>
        <h1 class="page-title">Overview Dashboard</h1>
        <p class="page-subtitle">National Labor Registry — real-time summary</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <span class="badge-pending" style="font-size:.75rem;padding:5px 12px;">
            <i class="bi bi-clock me-1"></i>{{ now()->format('d M Y') }}
        </span>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">

    {{-- Total Employers --}}
    <div class="col-6 col-lg-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-wrap" style="background:#EBF2FF;color:#1E3A6E;">
                    <i class="bi bi-building"></i>
                </div>
                <span class="stat-label">Total Employers</span>
            </div>
            <div class="stat-value">{{ number_format($total_employers) }}</div>
            <a href="{{ route('gov.employers.index') }}" class="text-decoration-none" style="font-size:.75rem;color:var(--navy-600);font-weight:600;">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Verified Employers --}}
    <div class="col-6 col-lg-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-wrap" style="background:#D1FAE5;color:#065F46;">
                    <i class="bi bi-patch-check"></i>
                </div>
                <span class="stat-label">Verified Employers</span>
            </div>
            <div class="stat-value">{{ number_format($verified_employers) }}</div>
            @if($total_employers > 0)
                <div class="stat-change up">{{ round(($verified_employers / $total_employers) * 100) }}% verified</div>
            @endif
        </div>
    </div>

    {{-- Total Employees --}}
    <div class="col-6 col-lg-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-wrap" style="background:#EEF2FF;color:#4338CA;">
                    <i class="bi bi-people"></i>
                </div>
                <span class="stat-label">Total Employees</span>
            </div>
            <div class="stat-value">{{ number_format($total_employees) }}</div>
            <a href="{{ route('gov.employees.index') }}" class="text-decoration-none" style="font-size:.75rem;color:var(--navy-600);font-weight:600;">
                View registry <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Active Employees --}}
    <div class="col-6 col-lg-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-wrap" style="background:#ECFDF5;color:#059669;">
                    <i class="bi bi-person-check"></i>
                </div>
                <span class="stat-label">Active Employees</span>
            </div>
            <div class="stat-value">{{ number_format($active_employees) }}</div>
            @if($total_employees > 0)
                <div class="stat-change up">{{ round(($active_employees / $total_employees) * 100) }}% active</div>
            @endif
        </div>
    </div>

    {{-- Pending Transfers --}}
    <div class="col-6 col-lg-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-wrap" style="background:#FFFBEB;color:#D97706;">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <span class="stat-label">Pending Transfers</span>
            </div>
            <div class="stat-value">{{ number_format($pending_transfers) }}</div>
            @if($pending_transfers > 0)
                <a href="{{ route('gov.transfers.index') }}" class="text-decoration-none" style="font-size:.75rem;color:#D97706;font-weight:600;">
                    Review now <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <span style="font-size:.75rem;color:var(--slate-400);">All clear</span>
            @endif
        </div>
    </div>

    {{-- Pending Claims --}}
    <div class="col-6 col-lg-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="stat-icon-wrap" style="background:#FEF2F2;color:#DC2626;">
                    <i class="bi bi-flag"></i>
                </div>
                <span class="stat-label">Pending Claims</span>
            </div>
            <div class="stat-value">{{ number_format($pending_claims) }}</div>
            @if($pending_claims > 0)
                <a href="{{ route('gov.claims.index') }}" class="text-decoration-none" style="font-size:.75rem;color:#DC2626;font-weight:600;">
                    Review now <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <span style="font-size:.75rem;color:var(--slate-400);">All clear</span>
            @endif
        </div>
    </div>

</div>

{{-- ── Quick Action Links ── --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-lightning-charge text-warning"></i>
        <span class="card-header-title">Quick Actions</span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('gov.employers.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center gap-2 py-3">
                    <i class="bi bi-building fs-4"></i>
                    <span>Manage Employers</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('gov.employees.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center gap-2 py-3">
                    <i class="bi bi-people fs-4"></i>
                    <span>Employee Registry</span>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('gov.transfers.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center gap-2 py-3">
                    <i class="bi bi-arrow-left-right fs-4"></i>
                    <span>Transfer Requests</span>
                    @if($pending_transfers > 0)
                        <span class="badge bg-warning text-dark">{{ $pending_transfers }}</span>
                    @endif
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('gov.claims.index') }}" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center gap-2 py-3">
                    <i class="bi bi-flag fs-4"></i>
                    <span>Claims Review</span>
                    @if($pending_claims > 0)
                        <span class="badge bg-danger">{{ $pending_claims }}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
