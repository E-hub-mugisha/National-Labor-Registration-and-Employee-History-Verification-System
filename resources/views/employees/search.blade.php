{{-- resources/views/employees/search.blade.php --}}
@extends('layouts.app')

@section('title', 'Search by National ID')

@section('content')

<style>

    /* ── Page layout ── */
    .search-page-wrap {
        max-width: 680px;
    }

    /* ── Hero icon ── */
    .search-hero-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, var(--navy-700), var(--navy-500));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: #fff;
        box-shadow: 0 8px 24px rgba(15,32,64,.3), 0 0 0 6px rgba(15,32,64,.08);
    }

    /* ── Search form card ── */
    .search-form-card {
        background: #fff;
        border: 1px solid var(--slate-200);
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        box-shadow: var(--shadow-md);
    }

    .search-input-group { border-radius: var(--radius-md); overflow: hidden; }

    .search-input-icon {
        background: var(--slate-100);
        border-color: var(--slate-200);
        color: var(--navy-600);
        font-size: 1.05rem;
        border-right: none;
        padding: 0 .9rem;
    }

    .search-input {
        border-color: var(--slate-200);
        border-left: none;
        font-size: .95rem;
        letter-spacing: .04em;
        padding: .65rem .85rem;
        box-shadow: none !important;
    }

    .search-input:focus { border-color: var(--navy-500); }

    .search-input:focus + .btn-search,
    .search-input-group:focus-within .search-input-icon {
        border-color: var(--navy-500);
    }

    .btn-search {
        background: var(--navy-600);
        border-color: var(--navy-600);
        color: #fff;
        font-weight: 700;
        font-size: .88rem;
        padding: 0 1.5rem;
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0 !important;
        transition: var(--transition);
    }

    .btn-search:hover {
        background: var(--navy-700);
        border-color: var(--navy-700);
        color: #fff;
    }

    .search-hint {
        font-size: .72rem;
        color: var(--slate-400);
    }

    /* ── State cards (idle / not found) ── */
    .state-card {
        border: 1.5px dashed var(--slate-200);
        border-radius: var(--radius-lg);
        background: #fff;
        padding: 2.5rem 1.5rem;
        text-align: center;
    }

    .state-notfound {
        border-color: #FDE68A;
        background: #FFFBEB;
    }

    .state-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: var(--slate-100);
        color: var(--slate-400);
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto .9rem;
    }

    .state-icon--warning {
        background: #FEF3C7;
        color: #D97706;
    }

    .state-title {
        font-size: .95rem;
        font-weight: 700;
        color: var(--slate-700);
        margin-bottom: .35rem;
    }

    .state-text {
        font-size: .82rem;
        color: var(--slate-500);
        margin: 0;
    }

    .state-tips {
        display: flex;
        flex-direction: column;
        gap: .4rem;
        align-items: center;
    }

    .state-tip {
        font-size: .76rem;
        color: var(--slate-500);
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .nid-code {
        font-family: 'DM Mono', monospace;
        font-size: .85em;
        background: #FEF3C7;
        color: #92400E;
        padding: 2px 7px;
        border-radius: 5px;
        border: 1px solid #FDE68A;
    }

    /* ── Result card ── */
    .result-card {
        border: 1px solid var(--slate-200);
        border-radius: var(--radius-lg);
        background: #fff;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        animation: slideUp .22s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .result-status-bar {
        height: 5px;
        width: 100%;
    }

    /* ── Profile row ── */
    .result-profile {
        display: flex;
        align-items: flex-start;
        gap: 1.1rem;
        padding: 1.25rem 1.5rem 0;
        flex-wrap: wrap;
    }

    .result-avatar-wrap {
        width: 76px;
        height: 76px;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 3px solid var(--slate-200);
        flex-shrink: 0;
        background: #fff;
    }

    .result-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .result-avatar-placeholder {
        width: 100%;
        height: 100%;
        background: var(--blue-100);
        color: var(--navy-600);
        font-weight: 800;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        letter-spacing: -.02em;
    }

    .result-identity { flex: 1; min-width: 0; }

    .result-name {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--slate-800);
        margin: 0;
        line-height: 1.3;
    }

    /* ── Info chips ── */
    .info-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .73rem;
        color: var(--slate-600);
        background: var(--slate-100);
        padding: .25rem .65rem;
        border-radius: 20px;
        border: 1px solid var(--slate-200);
    }

    .info-chip i { color: var(--slate-400); font-size: .75rem; }

    /* ── Details grid ── */
    .result-details-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        margin: 1rem 0 0;
        border-top: 1px solid var(--slate-100);
    }

    .result-detail-item {
        padding: .85rem 1.5rem;
        border-bottom: 1px solid var(--slate-100);
        border-right: 1px solid var(--slate-100);
    }

    .result-detail-item:nth-child(3n) { border-right: none; }
    .result-detail-full { grid-column: 1 / -1; border-right: none; }

    .result-detail-label {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--slate-400);
        margin-bottom: .25rem;
    }

    .result-detail-value {
        font-size: .82rem;
        font-weight: 600;
        color: var(--slate-700);
    }

    .result-detail-sub {
        font-weight: 400;
        color: var(--slate-400);
        font-size: .78rem;
    }

    /* ── Skills ── */
    .skill-tag {
        display: inline-block;
        font-size: .7rem;
        font-weight: 600;
        padding: 2px 9px;
        border-radius: 20px;
        background: var(--blue-100);
        color: var(--navy-600);
        border: 1px solid rgba(30,58,110,.1);
    }

    /* ── Result sections (employment, claims) ── */
    .result-section {
        border-top: 1px solid var(--slate-100);
        padding: .9rem 1.5rem;
    }

    .result-section-label {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--slate-400);
        margin-bottom: .6rem;
    }

    /* ── Employment mini-list ── */
    .result-emp-list { display: flex; flex-direction: column; gap: .45rem; }

    .result-emp-row {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-size: .8rem;
    }

    .result-emp-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--slate-300);
        flex-shrink: 0;
    }

    .result-emp-dot--active { background: var(--green-500); }

    .result-emp-name {
        font-weight: 600;
        color: var(--slate-700);
        flex: 1;
    }

    .result-emp-dates { color: var(--slate-400); font-size: .75rem; }

    .result-emp-more {
        font-size: .73rem;
        color: var(--slate-400);
        padding-left: 1.3rem;
        font-style: italic;
    }

    /* ── Result footer ── */
    .result-footer {
        border-top: 1px solid var(--slate-100);
        padding: .85rem 1.5rem;
        background: var(--slate-50);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .result-footer-meta {
        font-size: .73rem;
        color: var(--slate-400);
    }

    /* ── Responsive ── */
    @media (max-width: 575.98px) {
        .result-details-grid { grid-template-columns: repeat(2, 1fr); }
        .result-detail-item:nth-child(3n) { border-right: 1px solid var(--slate-100); }
        .result-detail-item:nth-child(2n) { border-right: none; }
        .result-profile { flex-direction: column; }
    }
</style>

<div class="search-page-wrap mx-auto">

    {{-- ── Page Heading ──────────────────────────────────────────────────── --}}
    <div class="text-center mb-4">
        <div class="search-hero-icon mx-auto mb-3">
            <i class="bi bi-person-badge"></i>
        </div>
        <h1 class="page-title">Employee Lookup</h1>
        <p class="page-subtitle mx-auto" style="max-width:420px;">
            Enter a National ID number to retrieve the employee's full registry record instantly.
        </p>
    </div>

    {{-- ── Search Form ───────────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('employees.search') }}" class="search-form-card mb-4">
        <div class="input-group input-group-lg search-input-group">
            <span class="input-group-text search-input-icon">
                <i class="bi bi-credit-card-2-front"></i>
            </span>
            <input type="text"
                   name="national_id"
                   id="national_id"
                   value="{{ request('national_id') }}"
                   autofocus
                   autocomplete="off"
                   spellcheck="false"
                   placeholder="Enter National ID number…"
                   class="form-control search-input font-mono">
            <button type="submit" class="btn btn-search">
                <i class="bi bi-search me-2"></i>
                Search
            </button>
        </div>
        <div class="search-hint mt-2 text-center">
            <i class="bi bi-shield-lock me-1"></i>
            Searches are logged in the audit trail for compliance purposes.
        </div>
    </form>

    {{-- ══════════════════════════════════════════
         STATE: Initial (no search yet)
    ══════════════════════════════════════════ --}}
    @if(! $searched)
    <div class="state-card state-idle">
        <div class="state-icon">
            <i class="bi bi-search"></i>
        </div>
        <div class="state-title">Ready to search</div>
        <p class="state-text">Type a National ID in the field above and press <strong>Search</strong> to look up an employee.</p>

        <div class="state-tips mt-3">
            <div class="state-tip">
                <i class="bi bi-info-circle text-primary"></i>
                National IDs are 16 digits long
            </div>
            <div class="state-tip">
                <i class="bi bi-info-circle text-primary"></i>
                Partial IDs are not supported — enter the full number
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         STATE: Searched but not found
    ══════════════════════════════════════════ --}}
    @if($searched && ! $employee)
    <div class="state-card state-notfound">
        <div class="state-icon state-icon--warning">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <div class="state-title">No record found</div>
        <p class="state-text">
            No employee matched National ID
            <code class="nid-code">{{ request('national_id') }}</code>.
        </p>
        <div class="d-flex align-items-center justify-content-center gap-2 mt-3 flex-wrap">
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to list
            </a>
            <a href="{{ route('employees.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-person-plus me-1"></i> Register this employee
            </a>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         STATE: Employee found
    ══════════════════════════════════════════ --}}
    @if($employee)

    @php
        $statusMap = [
            'active'      => ['cls' => 'badge-verified', 'icon' => 'check-circle-fill', 'bar' => '#00B85A'],
            'unemployed'  => ['cls' => 'badge-pending',  'icon' => 'clock-fill',         'bar' => '#F59E0B'],
            'blacklisted' => ['cls' => 'badge-rejected', 'icon' => 'x-circle-fill',      'bar' => '#DC2626'],
        ];
        $s = $statusMap[$employee->status] ?? ['cls' => 'badge-pending', 'icon' => 'dash-circle', 'bar' => '#94A3B8'];
    @endphp

    <div class="result-card">

        {{-- Status bar --}}
        <div class="result-status-bar" style="background:{{ $s['bar'] }};"></div>

        {{-- ── Profile section ── --}}
        <div class="result-profile">

            {{-- Avatar --}}
            <div class="result-avatar-wrap">
                @if($employee->photo)
                    <img src="{{ Storage::url($employee->photo) }}"
                         alt="{{ $employee->full_name }}"
                         class="result-avatar-img">
                @else
                    <div class="result-avatar-placeholder">
                        {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                    </div>
                @endif
            </div>

            {{-- Identity --}}
            <div class="result-identity">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h2 class="result-name">{{ $employee->full_name }}</h2>
                    <span class="{{ $s['cls'] }}">
                        <i class="bi bi-{{ $s['icon'] }} me-1"></i>{{ ucfirst($employee->status) }}
                    </span>
                </div>
                <div class="mb-2">
                    <span class="nida-badge">
                        <i class="bi bi-credit-card-2-front"></i>
                        {{ $employee->national_id }}
                    </span>
                </div>

                {{-- Contact row --}}
                <div class="d-flex flex-wrap gap-2">
                    <span class="info-chip"><i class="bi bi-telephone-fill"></i>{{ $employee->phone }}</span>
                    <span class="info-chip"><i class="bi bi-envelope-fill"></i>{{ $employee->email }}</span>
                    @if($employee->province)
                    <span class="info-chip">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ collect([$employee->district, $employee->province])->filter()->implode(', ') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Quick details grid ── --}}
        <div class="result-details-grid">

            <div class="result-detail-item">
                <div class="result-detail-label">Date of Birth</div>
                <div class="result-detail-value">
                    {{ $employee->date_of_birth->format('d M Y') }}
                    <span class="result-detail-sub">({{ $employee->age }} yrs)</span>
                </div>
            </div>

            <div class="result-detail-item">
                <div class="result-detail-label">Gender</div>
                <div class="result-detail-value">{{ ucfirst($employee->gender) }}</div>
            </div>

            <div class="result-detail-item">
                <div class="result-detail-label">Current Employer</div>
                <div class="result-detail-value">
                    {{ $employee->currentEmployer?->name ?? '—' }}
                </div>
            </div>

            @if($employee->highest_qualification)
            <div class="result-detail-item" style="grid-column: span 2;">
                <div class="result-detail-label">Qualification</div>
                <div class="result-detail-value">{{ $employee->highest_qualification }}</div>
            </div>
            @endif

            @if($employee->skills)
            <div class="result-detail-item result-detail-full">
                <div class="result-detail-label">Skills</div>
                <div class="result-detail-value">
                    <div class="d-flex flex-wrap gap-1 mt-1">
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

        {{-- ── Employment snippet ── --}}
        @if($employee->employmentRecords->isNotEmpty())
        <div class="result-section">
            <div class="result-section-label">
                <i class="bi bi-briefcase-fill me-1"></i> Employment History
                <span class="ms-1 badge rounded-pill"
                      style="background:var(--blue-100);color:var(--navy-600);font-size:.65rem;font-weight:700;vertical-align:middle;">
                    {{ $employee->employmentRecords->count() }}
                </span>
            </div>
            <div class="result-emp-list">
                @foreach($employee->employmentRecords->take(3) as $record)
                <div class="result-emp-row">
                    <div class="result-emp-dot {{ is_null($record->end_date) ? 'result-emp-dot--active' : '' }}"></div>
                    <span class="result-emp-name">{{ $record->employer->name ?? 'Unknown' }}</span>
                    <span class="result-emp-dates">
                        {{ $record->start_date?->format('M Y') }} – {{ $record->end_date?->format('M Y') ?? 'Present' }}
                    </span>
                    @if(is_null($record->end_date))
                        <span class="badge-verified" style="font-size:.62rem;margin-left:.25rem;">Current</span>
                    @endif
                </div>
                @endforeach
                @if($employee->employmentRecords->count() > 3)
                <div class="result-emp-more">
                    <i class="bi bi-three-dots me-1"></i>
                    {{ $employee->employmentRecords->count() - 3 }} more record(s) — view full profile
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- ── Claims snippet ── --}}
        @if($employee->claims->isNotEmpty())
        <div class="result-section">
            <div class="result-section-label">
                <i class="bi bi-flag-fill me-1"></i> Claims
                <span class="ms-1 badge rounded-pill"
                      style="background:#FEF3C7;color:#92400E;font-size:.65rem;font-weight:700;vertical-align:middle;">
                    {{ $employee->claims->count() }}
                </span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @foreach($employee->claims->take(5) as $claim)
                @php
                    $cb = match($claim->status ?? '') {
                        'approved' => 'badge-verified',
                        'rejected' => 'badge-rejected',
                        default    => 'badge-pending',
                    };
                @endphp
                <span class="{{ $cb }}">
                    {{ $claim->reference ?? '#' . $claim->id }}
                    &middot; {{ ucfirst($claim->status ?? 'pending') }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Action footer ── --}}
        <div class="result-footer">
            <span class="result-footer-meta">
                <i class="bi bi-clock me-1"></i>
                Last updated {{ $employee->updated_at->diffForHumans() }}
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('employees.edit', $employee) }}"
                   class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('employees.show', $employee) }}"
                   class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                    View Full Profile <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>{{-- /result-card --}}
    @endif

</div>{{-- /search-page-wrap --}}

@endsection


