@extends('layouts.app')

@section('title', 'Employment Record – ' . $employee->full_name)

@section('content')
<style>
    :root {
        --er-accent:     #0a8f6e;
        --er-accent-dim: #077a5e;
        --er-accent-bg:  rgba(10,143,110,.08);
        --er-accent-bdr: rgba(10,143,110,.25);
    }

    .er-breadcrumb a { color: var(--er-accent); text-decoration: none; }
    .er-breadcrumb a:hover { text-decoration: underline; }

    .er-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        border: 2px solid var(--er-accent);
        background: #f0f3f5; flex-shrink: 0; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.15rem; color: var(--er-accent);
    }
    .er-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .badge-active-er {
        background: var(--er-accent-bg); color: var(--er-accent);
        border: 1px solid var(--er-accent-bdr);
        font-size: .75rem; font-weight: 600; padding: .25rem .65rem;
        border-radius: 6px; display: inline-flex; align-items: center; gap: .35rem;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .btn-accent {
        background: var(--er-accent); color: #fff; border: none; font-weight: 600;
    }
    .btn-accent:hover, .btn-accent:focus {
        background: var(--er-accent-dim); color: #fff;
        box-shadow: 0 4px 14px var(--er-accent-bg);
    }

    /* Detail label/value pairs */
    .detail-label {
        font-size: .68rem; text-transform: uppercase;
        letter-spacing: .08em; color: #6c757d; font-weight: 600;
        margin-bottom: .2rem;
    }
    .detail-value {
        font-size: .92rem; color: #212529; font-weight: 500;
    }
    .detail-value.muted { color: #6c757d; font-weight: 400; }

    /* Section heading */
    .section-title {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .1em; color: var(--er-accent);
        border-bottom: 1px solid #dee2e6; padding-bottom: .4rem;
        margin-bottom: 1.25rem;
    }

    /* Timeline pill for duration */
    .duration-pill {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--er-accent-bg); border: 1px solid var(--er-accent-bdr);
        color: var(--er-accent); border-radius: 20px;
        font-size: .78rem; font-weight: 600; padding: .3rem .85rem;
    }

    .rehire-yes { color: var(--er-accent); font-weight: 600; }
    .rehire-no  { color: #dc2626; font-weight: 600; }

    .remarks-box {
        background: #f8f9fa; border: 1px solid #dee2e6;
        border-radius: 8px; padding: 1rem; font-size: .85rem;
        color: #495057; line-height: 1.6; white-space: pre-wrap;
    }

    .meta-row { font-size: .78rem; color: #adb5bd; }
</style>

<div class="container-xl py-4">

    {{-- ── Header ─────────────────────────────────────────── --}}
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb" class="er-breadcrumb mb-2">
                <ol class="breadcrumb mb-0" style="font-size:.75rem">
                    <li class="breadcrumb-item"><a href="{{ route('employer.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('employment-records.index', $employee) }}">{{ $employee->full_name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Record #{{ $employmentRecord->id }}</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <div class="er-avatar">
                    @if($employee->profile_photo)
                        <img src="{{ asset($employee->profile_photo) }}" alt="{{ $employee->full_name }}">
                    @else
                        {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                    @endif
                </div>
                <div>
                    <h1 class="h4 fw-bold mb-0">{{ $employee->full_name }}</h1>
                    <small class="text-muted">
                        ID&nbsp;<span class="fw-semibold" style="color:var(--er-accent)">{{ $employee->employee_id ?? '#'.$employee->id }}</span>
                        &nbsp;·&nbsp;{{ $employmentRecord->position }}
                        @if($employmentRecord->department) &nbsp;·&nbsp;{{ $employmentRecord->department }} @endif
                    </small>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('employment-records.index', $employee) }}"
               class="btn btn-outline-secondary btn-sm px-3">
                <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd"/>
                </svg>
                All Records
            </a>
            <a href="{{ route('employment-records.edit', [$employee, $employmentRecord]) }}"
               class="btn btn-accent btn-sm px-3">
                <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                    <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z"/>
                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z"/>
                </svg>
                Edit Record
            </a>
        </div>
    </div>

    {{-- ── Status Banner ────────────────────────────────────── --}}
    <div class="card border rounded-3 shadow-sm mb-4 overflow-hidden">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 px-4">
            <div class="d-flex align-items-center gap-3">
                @if($employmentRecord->is_active)
                    <span class="badge-active-er">
                        <span class="badge-dot"></span> Active
                    </span>
                @else
                    <span class="badge bg-light text-secondary border" style="font-size:.75rem">Inactive</span>
                @endif
                <span class="text-muted" style="font-size:.85rem">{{ $employmentRecord->position }}</span>
                @if($employmentRecord->department)
                    <span class="text-muted" style="font-size:.85rem">·</span>
                    <span class="text-muted" style="font-size:.85rem">{{ $employmentRecord->department }}</span>
                @endif
            </div>
            <div class="duration-pill">
                <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/>
                </svg>
                {{ $employmentRecord->duration }}
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── Left Column ─────────────────────────────────── --}}
        <div class="col-lg-8">

            {{-- Role & Employment --}}
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Role &amp; Employment</div>
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="detail-label">Position</div>
                            <div class="detail-value">{{ $employmentRecord->position }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Department</div>
                            <div class="detail-value {{ $employmentRecord->department ? '' : 'muted' }}">
                                {{ $employmentRecord->department ?? 'Not specified' }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Salary (RWF)</div>
                            <div class="detail-value">{{ number_format($employmentRecord->salary, 0) }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                @if($employmentRecord->is_active)
                                    <span class="badge-active-er">
                                        <span class="badge-dot"></span> Active
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary border" style="font-size:.75rem">
                                        {{ ucfirst($employmentRecord->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Employment Dates --}}
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Employment Period</div>
                    <div class="row g-4">
                        <div class="col-sm-4">
                            <div class="detail-label">Start Date</div>
                            <div class="detail-value">{{ $employmentRecord->start_date->format('d M Y') }}</div>
                        </div>
                        <div class="col-sm-4">
                            <div class="detail-label">End Date</div>
                            <div class="detail-value {{ $employmentRecord->end_date ? '' : 'muted' }}">
                                {{ $employmentRecord->end_date?->format('d M Y') ?? 'Present' }}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="detail-label">Duration</div>
                            <div class="detail-value" style="color:var(--er-accent)">{{ $employmentRecord->duration }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Exit Info (only if not active) --}}
            @if(!$employmentRecord->is_active)
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Exit Information</div>
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="detail-label">Exit Reason</div>
                            <div class="detail-value {{ $employmentRecord->exit_reason ? '' : 'muted' }}">
                                {{ $employmentRecord->exit_reason ? $employmentRecord->exit_reason_label : 'Not specified' }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Eligible for Rehire</div>
                            <div class="detail-value">
                                @if(is_null($employmentRecord->eligible_for_rehire))
                                    <span class="text-muted">Not specified</span>
                                @elseif($employmentRecord->eligible_for_rehire)
                                    <span class="rehire-yes">Yes</span>
                                @else
                                    <span class="rehire-no">No</span>
                                @endif
                            </div>
                        </div>
                        @if($employmentRecord->exit_details)
                        <div class="col-12">
                            <div class="detail-label">Exit Details</div>
                            <div class="remarks-box mt-1">{{ $employmentRecord->exit_details }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Conduct & Remarks --}}
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Conduct &amp; Assessment</div>
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="detail-label">Conduct Rating</div>
                            <div class="detail-value">
                                @if($employmentRecord->conduct_rating)
                                    <span class="badge {{ $employmentRecord->conduct_badge }}">
                                        {{ ucfirst(str_replace('_',' ',$employmentRecord->conduct_rating)) }}
                                    </span>
                                @else
                                    <span class="text-muted">Not rated</span>
                                @endif
                            </div>
                        </div>
                        @if($employmentRecord->is_active)
                        <div class="col-sm-6">
                            <div class="detail-label">Eligible for Rehire</div>
                            <div class="detail-value">
                                @if(is_null($employmentRecord->eligible_for_rehire))
                                    <span class="text-muted">Not specified</span>
                                @elseif($employmentRecord->eligible_for_rehire)
                                    <span class="rehire-yes">Yes</span>
                                @else
                                    <span class="rehire-no">No</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($employmentRecord->conduct_remarks)
                        <div class="col-12">
                            <div class="detail-label">Conduct Remarks</div>
                            <div class="remarks-box mt-1">{{ $employmentRecord->conduct_remarks }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Right Column ─────────────────────────────────── --}}
        <div class="col-lg-4">

            {{-- Quick Facts --}}
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Quick Facts</div>
                    <ul class="list-unstyled mb-0" style="font-size:.85rem">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Record ID</span>
                            <span class="fw-semibold">#{{ $employmentRecord->id }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Recorded By</span>
                            <span class="fw-semibold">{{ $employmentRecord->recordedBy?->name ?? '—' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Created</span>
                            <span>{{ $employmentRecord->created_at->format('d M Y') }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2">
                            <span class="text-muted">Last Updated</span>
                            <span>{{ $employmentRecord->updated_at->format('d M Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Actions</div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('employment-records.edit', [$employee, $employmentRecord]) }}"
                           class="btn btn-accent btn-sm">
                            <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                                <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z"/>
                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z"/>
                            </svg>
                            Edit This Record
                        </a>
                        <a href="{{ route('employment-records.index', $employee) }}"
                           class="btn btn-outline-secondary btn-sm">
                            <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd"/>
                            </svg>
                            All Records
                        </a>

                        {{-- Delete --}}
                        <form method="POST"
                              action="{{ route('employment-records.destroy', [$employee, $employmentRecord]) }}"
                              onsubmit="return confirm('Delete this employment record? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd"/>
                                </svg>
                                Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
