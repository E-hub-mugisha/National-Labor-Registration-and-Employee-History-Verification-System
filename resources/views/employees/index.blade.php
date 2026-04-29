@extends('layouts.app')

@section('title', 'Employees')

@section('content')


<style>
    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        font-size: .85rem;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: var(--transition);
        color: var(--slate-400);
        text-decoration: none;
    }

    .action-btn-view:hover  { background: var(--blue-100);  color: var(--navy-600); }
    .action-btn-edit:hover  { background: #FFFBEB; color: #B45309; }
    .action-btn-delete:hover { background: #FEF2F2; color: #DC2626; }

    /* ── Empty state ── */
    .empty-state { padding: 2rem 1rem; }

    .empty-state-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: var(--slate-100);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--slate-400);
        margin: 0 auto 1rem;
    }

    .empty-state-title {
        font-size: .95rem;
        font-weight: 700;
        color: var(--slate-600);
        margin-bottom: .3rem;
    }

    .empty-state-text {
        font-size: .82rem;
        color: var(--slate-400);
        margin: 0;
    }

    /* ── Pagination override ── */
    .pagination-wrap .pagination {
        margin: 0;
        gap: 3px;
    }

    .pagination-wrap .page-link {
        font-size: .78rem;
        font-weight: 600;
        border-radius: 6px !important;
        border: 1px solid var(--slate-200);
        color: var(--slate-600);
        padding: .3rem .65rem;
        transition: var(--transition);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .pagination-wrap .page-link:hover {
        background: var(--blue-100);
        color: var(--navy-600);
        border-color: var(--blue-100);
    }

    .pagination-wrap .page-item.active .page-link {
        background: var(--navy-600);
        border-color: var(--navy-600);
        color: #fff;
        box-shadow: none;
    }

    .pagination-wrap .page-item.disabled .page-link {
        color: var(--slate-300);
        background: transparent;
    }

    /* ── Filter bar input group fix ── */
    .input-group .input-group-text {
        border-color: var(--slate-200);
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
    }

    .input-group .form-control {
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }
</style>

{{-- ── Page Header ──────────────────────────────────────────────────────── --}}
<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Employees</li>
            </ol>
        </nav>
        <h1 class="page-title">Employees</h1>
        <p class="page-subtitle">
            <i class="bi bi-database me-1"></i>
            {{ number_format($employees->total()) }} {{ Str::plural('record', $employees->total()) }} found
        </p>
    </div>
    <a href="{{ route('employees.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2">
        <i class="bi bi-person-plus-fill"></i>
        New Employee
    </a>
</div>

{{-- ── Filters ───────────────────────────────────────────────────────────── --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('employees.index') }}">
            <div class="row g-2 align-items-center">

                {{-- Keyword search --}}
                <div class="col-12 col-md-4 col-lg-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted" style="font-size:.8rem;"></i>
                        </span>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Name, ID, email, phone…"
                               class="form-control border-start-0 ps-0"
                               style="box-shadow:none;">
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All statuses</option>
                        <option value="active"      {{ request('status') === 'active'      ? 'selected' : '' }}>Active</option>
                        <option value="unemployed"  {{ request('status') === 'unemployed'  ? 'selected' : '' }}>Unemployed</option>
                        <option value="blacklisted" {{ request('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                    </select>
                </div>

                {{-- Province --}}
                <div class="col-6 col-md-2">
                    <select name="province" class="form-select form-select-sm">
                        <option value="">All provinces</option>
                        @foreach($provinces as $p)
                            <option value="{{ $p }}" {{ request('province') === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Actions --}}
                <div class="col-12 col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search','status','province']))
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            <i class="bi bi-x-lg me-1"></i> Clear
                        </a>
                    @endif
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ── Table ─────────────────────────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="stat-icon-wrap bg-primary bg-opacity-10" style="width:32px;height:32px;border-radius:8px;font-size:.9rem;">
                <i class="bi bi-people-fill text-primary"></i>
            </span>
            <span class="card-header-title">Employee Registry</span>
        </div>
        <span class="badge rounded-pill" style="background:var(--blue-100);color:var(--navy-600);font-size:.72rem;font-weight:700;">
            {{ number_format($employees->total()) }} total
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>National ID</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Employer</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    {{-- Employee info --}}
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($employee->photo)
                                <img src="{{ Storage::url($employee->photo) }}"
                                     alt="{{ $employee->full_name }}"
                                     class="rounded-circle object-fit-cover"
                                     style="width:36px;height:36px;border:2px solid var(--slate-200);">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                     style="width:36px;height:36px;background:var(--blue-100);color:var(--navy-600);font-weight:700;font-size:.78rem;border:2px solid var(--slate-200);">
                                    {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('employees.show', $employee) }}"
                                   class="fw-600 text-decoration-none"
                                   style="font-weight:600;color:var(--slate-800);">
                                    {{ $employee->full_name }}
                                </a>
                                <div style="font-size:.73rem;color:var(--slate-400);">
                                    {{ ucfirst($employee->gender) }} &middot; Age {{ $employee->age }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- National ID --}}
                    <td>
                        <span class="nida-badge">
                            <i class="bi bi-credit-card-2-front"></i>
                            {{ $employee->national_id }}
                        </span>
                    </td>

                    {{-- Contact --}}
                    <td>
                        <div style="font-size:.82rem;color:var(--slate-700);">
                            <i class="bi bi-telephone me-1 text-muted" style="font-size:.75rem;"></i>
                            {{ $employee->phone }}
                        </div>
                        <div class="text-truncate" style="font-size:.73rem;color:var(--slate-400);max-width:160px;">
                            <i class="bi bi-envelope me-1" style="font-size:.7rem;"></i>
                            {{ $employee->email }}
                        </div>
                    </td>

                    {{-- Location --}}
                    <td>
                        <div class="d-flex align-items-center gap-1" style="font-size:.82rem;color:var(--slate-600);">
                            <i class="bi bi-geo-alt text-muted" style="font-size:.75rem;"></i>
                            {{ collect([$employee->district, $employee->province])->filter()->implode(', ') ?: '—' }}
                        </div>
                    </td>

                    {{-- Employer --}}
                    <td>
                        @if($employee->currentEmployer)
                            <div class="d-flex align-items-center gap-1" style="font-size:.82rem;color:var(--slate-700);">
                                <i class="bi bi-building text-muted" style="font-size:.75rem;"></i>
                                {{ $employee->currentEmployer->name }}
                            </div>
                        @else
                            <span style="color:var(--slate-400);font-size:.82rem;">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        @php
                            $statusMap = [
                                'active'      => ['cls' => 'badge-verified', 'icon' => 'check-circle-fill'],
                                'unemployed'  => ['cls' => 'badge-pending',  'icon' => 'clock-fill'],
                                'blacklisted' => ['cls' => 'badge-rejected', 'icon' => 'x-circle-fill'],
                            ];
                            $s = $statusMap[$employee->status] ?? ['cls' => 'badge-pending', 'icon' => 'dash-circle'];
                        @endphp
                        <span class="{{ $s['cls'] }}">
                            <i class="bi bi-{{ $s['icon'] }} me-1"></i>
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="d-flex align-items-center justify-content-end gap-1">

                            {{-- View --}}
                            <a href="{{ route('employees.show', $employee) }}"
                               class="action-btn action-btn-view"
                               title="View profile">
                                <i class="bi bi-eye"></i>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('employees.edit', $employee) }}"
                               class="action-btn action-btn-edit"
                               title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($employee->full_name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="empty-state-title">No employees found</div>
                            <p class="empty-state-text">
                                Try adjusting your filters or
                                <a href="{{ route('employees.create') }}" style="color:var(--navy-600);">add a new employee</a>.
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($employees->hasPages())
    <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-2 py-3 px-4">
        <div style="font-size:.78rem;color:var(--slate-400);">
            Showing
            <strong style="color:var(--slate-700);">{{ $employees->firstItem() }}–{{ $employees->lastItem() }}</strong>
            of
            <strong style="color:var(--slate-700);">{{ number_format($employees->total()) }}</strong>
            records
        </div>
        <div class="pagination-wrap">
            {{ $employees->links() }}
        </div>
    </div>
    @endif
</div>

@endsection


