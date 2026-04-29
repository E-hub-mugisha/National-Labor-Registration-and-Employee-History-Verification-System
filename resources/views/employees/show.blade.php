@extends('layouts.app')

@section('title', $employee->full_name)

@section('content')

<style>

    /* ── Profile Banner ── */
    .profile-band {
        height: 88px;
        background: linear-gradient(120deg, var(--navy-800) 0%, var(--navy-600) 60%, var(--navy-500) 100%);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        position: relative;
        overflow: hidden;
    }

    .profile-band::after {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .profile-body { padding-top: 0; }

    /* ── Profile Avatar ── */
    .profile-avatar-wrap {
        width: 88px;
        height: 88px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: var(--shadow-md);
        margin-top: -44px;
        flex-shrink: 0;
        background: #fff;
        position: relative;
        z-index: 2;
    }

    .profile-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .profile-avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--blue-100);
        color: var(--navy-600);
        font-weight: 800;
        font-size: 1.75rem;
        letter-spacing: -.02em;
    }

    .profile-name {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--slate-800);
        line-height: 1.3;
    }

    /* ── Info chips (contact details) ── */
    .info-chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .78rem;
        color: var(--slate-600);
        background: var(--slate-100);
        padding: .3rem .75rem;
        border-radius: 20px;
        border: 1px solid var(--slate-200);
    }

    .info-chip i { color: var(--slate-400); font-size: .8rem; }

    /* ── Card header icon ── */
    .card-header-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: var(--blue-100);
        color: var(--navy-600);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .88rem;
        flex-shrink: 0;
    }

    /* ── Detail grid (key/value pairs) ── */
    .detail-grid { display: flex; flex-direction: column; }

    .detail-row {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: .75rem 1.25rem;
        border-bottom: 1px solid var(--slate-100);
        font-size: .82rem;
    }

    .detail-row:last-child { border-bottom: none; }

    .detail-row-full { flex-direction: column; gap: .35rem; }

    .detail-label {
        min-width: 130px;
        font-weight: 600;
        color: var(--slate-400);
        font-size: .76rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding-top: .1rem;
        flex-shrink: 0;
    }

    .detail-value { color: var(--slate-700); flex: 1; }

    /* ── Skills tags ── */
    .skills-tags { display: flex; flex-wrap: wrap; gap: .4rem; }

    .skill-tag {
        display: inline-block;
        font-size: .72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        background: var(--blue-100);
        color: var(--navy-600);
        border: 1px solid rgba(30,58,110,.1);
    }

    /* ── Employment Timeline ── */
    .emp-timeline { position: relative; }

    .emp-timeline-item {
        position: relative;
        padding-left: 1.5rem;
        padding-bottom: 1.25rem;
    }

    .emp-timeline-item:last-child { padding-bottom: 0; }

    .emp-timeline-item::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 20px;
        bottom: 0;
        width: 2px;
        background: var(--slate-200);
    }

    .emp-timeline-item:last-child::before { display: none; }

    .emp-timeline-dot {
        position: absolute;
        left: 0;
        top: 4px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--slate-200);
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px var(--slate-200);
    }

    .emp-timeline-item--current .emp-timeline-dot {
        background: var(--green-500);
        box-shadow: 0 0 0 2px var(--green-500);
    }

    .emp-company {
        font-weight: 700;
        font-size: .85rem;
        color: var(--slate-800);
    }

    .emp-period {
        font-size: .75rem;
        color: var(--slate-400);
        margin-top: .2rem;
    }

    .emp-duration {
        color: var(--slate-300);
    }

    /* ── Employer icon box ── */
    .employer-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        background: var(--blue-100);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ── List group override ── */
    .list-group-item {
        border-color: var(--slate-100);
    }

    /* ── Table inside card override ── */
    .card .table thead th {
        background: var(--slate-50);
        border-bottom: 1px solid var(--slate-200);
    }
</style>

{{-- ── Breadcrumb & Page Header ─────────────────────────────────────────── --}}
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                <li class="breadcrumb-item active">{{ $employee->full_name }}</li>
            </ol>
        </nav>
        <h1 class="page-title">Employee Profile</h1>
        <p class="page-subtitle">
            Registry record &middot; Last updated {{ $employee->updated_at->diffForHumans() }}
        </p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-2">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form method="POST" action="{{ route('employees.destroy', $employee) }}"
              onsubmit="return confirm('Remove {{ addslashes($employee->full_name) }} from the registry?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-2">
                <i class="bi bi-trash3"></i> Delete
            </button>
        </form>
    </div>
</div>

{{-- ── Hero / Profile Banner ─────────────────────────────────────────────── --}}
<div class="card profile-banner mb-4">
    <div class="card-body p-0">

        {{-- Coloured band --}}
        <div class="profile-band"></div>

        <div class="profile-body px-4 pb-4">
            <div class="d-flex flex-wrap align-items-end gap-4">

                {{-- Avatar --}}
                <div class="profile-avatar-wrap">
                    @if($employee->photo)
                        <img src="{{ Storage::url($employee->photo) }}"
                             alt="{{ $employee->full_name }}"
                             class="profile-avatar-img">
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                        </div>
                    @endif
                </div>

                {{-- Core info --}}
                <div class="flex-1" style="min-width:0;">
                    <div class="d-flex flex-wrap align-items-center gap-2 mt-2">
                        <h2 class="profile-name mb-0">{{ $employee->full_name }}</h2>

                        @php
                            $statusMap = [
                                'active'      => ['cls' => 'badge-verified', 'icon' => 'check-circle-fill'],
                                'unemployed'  => ['cls' => 'badge-pending',  'icon' => 'clock-fill'],
                                'blacklisted' => ['cls' => 'badge-rejected', 'icon' => 'x-circle-fill'],
                            ];
                            $s = $statusMap[$employee->status] ?? ['cls' => 'badge-pending', 'icon' => 'dash-circle'];
                        @endphp
                        <span class="{{ $s['cls'] }}">
                            <i class="bi bi-{{ $s['icon'] }} me-1"></i>{{ ucfirst($employee->status) }}
                        </span>
                    </div>

                    <div class="mt-1 mb-3">
                        <span class="nida-badge">
                            <i class="bi bi-credit-card-2-front"></i>
                            {{ $employee->national_id }}
                        </span>
                    </div>

                    {{-- Contact chips --}}
                    <div class="d-flex flex-wrap gap-3">
                        <span class="info-chip">
                            <i class="bi bi-telephone-fill"></i>
                            {{ $employee->phone }}
                        </span>
                        <span class="info-chip">
                            <i class="bi bi-envelope-fill"></i>
                            {{ $employee->email }}
                        </span>
                        @if($employee->province)
                        <span class="info-chip">
                            <i class="bi bi-geo-alt-fill"></i>
                            {{ collect([$employee->district, $employee->province])->filter()->implode(', ') }}
                        </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ── Body Grid ─────────────────────────────────────────────────────────── --}}
<div class="row g-4">

    {{-- ════════════════════════════
         LEFT COLUMN
    ════════════════════════════ --}}
    <div class="col-12 col-lg-8">

        {{-- Personal Details --}}
        <div class="card mb-4">
            <div class="card-header">
                <span class="card-header-icon"><i class="bi bi-person-lines-fill"></i></span>
                <span class="card-header-title">Personal Details</span>
            </div>
            <div class="card-body p-0">
                <div class="detail-grid">

                    <div class="detail-row">
                        <div class="detail-label">Date of Birth</div>
                        <div class="detail-value">{{ $employee->date_of_birth->format('d M Y') }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Age</div>
                        <div class="detail-value">{{ $employee->age }} years</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Gender</div>
                        <div class="detail-value">{{ ucfirst($employee->gender) }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $employee->district ?? '—' }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $employee->province ?? '—' }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Qualification</div>
                        <div class="detail-value">{{ $employee->highest_qualification ?? '—' }}</div>
                    </div>

                    @if($employee->skills)
                    <div class="detail-row detail-row-full">
                        <div class="detail-label">Skills</div>
                        <div class="detail-value">
                            <div class="skills-tags">
                                @foreach(preg_split('/[\n,]+/', $employee->skills) as $skill)
                                    @php $skill = trim($skill); @endphp
                                    @if($skill)
                                        <span class="skill-tag">{{ $skill }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Employment History --}}
        @if($employee->employmentRecords->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header">
                <span class="card-header-icon"><i class="bi bi-briefcase-fill"></i></span>
                <span class="card-header-title">Employment History</span>
                <span class="ms-auto badge rounded-pill"
                      style="background:var(--blue-100);color:var(--navy-600);font-size:.7rem;font-weight:700;">
                    {{ $employee->employmentRecords->count() }} {{ Str::plural('record', $employee->employmentRecords->count()) }}
                </span>
            </div>
            <div class="card-body">
                <div class="emp-timeline">
                    @foreach($employee->employmentRecords as $record)
                    <div class="emp-timeline-item {{ is_null($record->end_date) ? 'emp-timeline-item--current' : '' }}">
                        <div class="emp-timeline-dot"></div>
                        <div class="emp-timeline-content">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="emp-company">
                                    <i class="bi bi-building me-1"></i>
                                    {{ $record->employer->name ?? 'Unknown Employer' }}
                                </span>
                                @if(is_null($record->end_date))
                                    <span class="badge-verified" style="font-size:.65rem;">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.4rem;vertical-align:middle;"></i>Current
                                    </span>
                                @endif
                            </div>
                            <div class="emp-period">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $record->start_date?->format('M Y') ?? '?' }}
                                &nbsp;→&nbsp;
                                {{ $record->end_date?->format('M Y') ?? 'Present' }}
                                @if($record->start_date && $record->end_date)
                                    <span class="emp-duration">
                                        · {{ $record->start_date->diffForHumans($record->end_date, true) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Claims --}}
        @if($employee->claims->isNotEmpty())
        <div class="card mb-0">
            <div class="card-header">
                <span class="card-header-icon"><i class="bi bi-flag-fill"></i></span>
                <span class="card-header-title">Claims</span>
                <span class="ms-auto badge rounded-pill"
                      style="background:#FEF3C7;color:#92400E;font-size:.7rem;font-weight:700;">
                    {{ $employee->claims->count() }}
                </span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employee->claims as $claim)
                        <tr>
                            <td>
                                <span class="fw-600" style="font-weight:600;font-size:.82rem;color:var(--slate-800);">
                                    {{ $claim->reference ?? 'Claim #' . $claim->id }}
                                </span>
                            </td>
                            <td style="font-size:.82rem;color:var(--slate-500);">
                                {{ $claim->created_at->format('d M Y') }}
                            </td>
                            <td>
                                @php
                                    $clsBadge = match($claim->status ?? '') {
                                        'approved' => 'badge-verified',
                                        'rejected' => 'badge-rejected',
                                        default    => 'badge-pending',
                                    };
                                    $clsIcon = match($claim->status ?? '') {
                                        'approved' => 'check-circle-fill',
                                        'rejected' => 'x-circle-fill',
                                        default    => 'clock-fill',
                                    };
                                @endphp
                                <span class="{{ $clsBadge }}">
                                    <i class="bi bi-{{ $clsIcon }} me-1"></i>
                                    {{ ucfirst($claim->status ?? 'pending') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>

    {{-- ════════════════════════════
         RIGHT COLUMN
    ════════════════════════════ --}}
    <div class="col-12 col-lg-4">

        {{-- Current Employer --}}
        <div class="card mb-4">
            <div class="card-header">
                <span class="card-header-icon"><i class="bi bi-building-fill"></i></span>
                <span class="card-header-title">Current Employer</span>
            </div>
            <div class="card-body">
                @if($employee->currentEmployer)
                    <div class="d-flex align-items-center gap-3">
                        <div class="employer-icon">
                            <i class="bi bi-building" style="font-size:1.2rem;color:var(--navy-600);"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:.88rem;color:var(--slate-800);">
                                {{ $employee->currentEmployer->name }}
                            </div>
                            @isset($employee->currentEmployer->phone)
                            <div style="font-size:.78rem;color:var(--slate-400);margin-top:.15rem;">
                                <i class="bi bi-telephone me-1"></i>
                                {{ $employee->currentEmployer->phone }}
                            </div>
                            @endisset
                        </div>
                    </div>
                @else
                    <div class="text-center py-3">
                        <div style="font-size:1.5rem;color:var(--slate-300);margin-bottom:.4rem;">
                            <i class="bi bi-building-x"></i>
                        </div>
                        <p style="font-size:.8rem;color:var(--slate-400);margin:0;font-style:italic;">
                            No current employer on record.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Transfer Requests --}}
        @if($employee->transferRequests->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header">
                <span class="card-header-icon"><i class="bi bi-arrow-left-right"></i></span>
                <span class="card-header-title">Transfer Requests</span>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($employee->transferRequests as $tr)
                <li class="list-group-item d-flex align-items-center justify-content-between py-3 px-4"
                    style="font-size:.82rem;">
                    <span style="color:var(--slate-500);">
                        <i class="bi bi-calendar3 me-1" style="font-size:.75rem;"></i>
                        {{ $tr->created_at->format('d M Y') }}
                    </span>
                    @php
                        $trBadge = match($tr->status) {
                            'approved' => 'badge-verified',
                            'rejected' => 'badge-rejected',
                            default    => 'badge-pending',
                        };
                    @endphp
                    <span class="{{ $trBadge }}">{{ ucfirst($tr->status) }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Record Meta --}}
        <div class="card">
            <div class="card-header">
                <span class="card-header-icon"><i class="bi bi-info-circle-fill"></i></span>
                <span class="card-header-title">Record Info</span>
            </div>
            <div class="card-body p-0">
                <div class="detail-grid">
                    <div class="detail-row">
                        <div class="detail-label">Registered</div>
                        <div class="detail-value">{{ $employee->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Last Updated</div>
                        <div class="detail-value">{{ $employee->updated_at->diffForHumans() }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Record ID</div>
                        <div class="detail-value">
                            <span class="nida-badge" style="font-size:.68rem;">
                                #{{ $employee->id }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


