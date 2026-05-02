@extends('layouts.app')

@section('title', 'Employment Records – ' . $employee->full_name)

@section('content')
<style>
    /* ── Accent overrides on top of Bootstrap ── */
    :root {
        --er-accent:     #0a8f6e;
        --er-accent-dim: #077a5e;
        --er-accent-bg:  rgba(10,143,110,.08);
        --er-accent-bdr: rgba(10,143,110,.25);
    }

    /* Breadcrumb link */
    .er-breadcrumb a { color: var(--er-accent); text-decoration: none; }
    .er-breadcrumb a:hover { text-decoration: underline; }

    /* Avatar */
    .er-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        border: 2px solid var(--er-accent);
        background: #f0f3f5; flex-shrink: 0; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.15rem; color: var(--er-accent);
    }
    .er-avatar img { width: 100%; height: 100%; object-fit: cover; }

    /* Stat strip */
    .er-stat-value { font-size: 1.35rem; font-weight: 700; line-height: 1.2; }
    .er-stat-label { font-size: .68rem; text-transform: uppercase;
                     letter-spacing: .08em; color: #6c757d; }
    .er-stat-sub   { font-size: .7rem; color: #adb5bd; }

    /* Table tweaks */
    .er-table th { font-size: .68rem; text-transform: uppercase;
                   letter-spacing: .08em; white-space: nowrap; background: #f8f9fa; }
    .er-table td { vertical-align: middle; font-size: .85rem; }
    .er-table tbody tr:hover { background: #f0f7f5; }

    .pos-dept { font-size: .75rem; color: #6c757d; }

    .date-sep { color: #adb5bd; margin: 0 .2rem; }
    .date-dur { font-size: .72rem; color: #adb5bd; }

    .salary-val { font-variant-numeric: tabular-nums; font-weight: 500; }

    /* Active badge */
    .badge-active-er {
        background: var(--er-accent-bg); color: var(--er-accent);
        border: 1px solid var(--er-accent-bdr);
        font-size: .7rem; font-weight: 600; padding: .2rem .55rem;
        border-radius: 5px; display: inline-flex; align-items: center; gap: .3rem;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* Accent button */
    .btn-accent {
        background: var(--er-accent); color: #fff; border: none;
        font-weight: 600;
    }
    .btn-accent:hover, .btn-accent:focus {
        background: var(--er-accent-dim); color: #fff;
        box-shadow: 0 4px 14px var(--er-accent-bg);
    }

    /* Form section heading inside modal */
    .form-section-title {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .1em; color: var(--er-accent);
        border-bottom: 1px solid #dee2e6; padding-bottom: .4rem;
        margin-top: .5rem; margin-bottom: .25rem;
    }

    /* Focus ring */
    .form-control:focus, .form-select:focus {
        border-color: var(--er-accent);
        box-shadow: 0 0 0 .2rem rgba(10,143,110,.15);
    }

    /* Alert tint */
    .alert-er-success {
        background: var(--er-accent-bg); border: 1px solid var(--er-accent-bdr);
        color: var(--er-accent);
    }

    /* Empty state icon circle */
    .er-empty-icon {
        width: 58px; height: 58px; border-radius: 50%;
        background: #f0f3f5; border: 1px solid #dee2e6;
        display: flex; align-items: center; justify-content: center; color: #adb5bd;
    }
</style>

<div class="container-xl py-4">

    {{-- ── Alerts ─────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="alert alert-er-success d-flex align-items-center gap-2 mb-4 rounded-3" role="alert">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" flex-shrink="0">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger d-flex align-items-start gap-2 mb-4 rounded-3" role="alert">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0;margin-top:2px">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
        </svg>
        <div>
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- ── Page Header ─────────────────────────────────────── --}}
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
        <div>
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="er-breadcrumb mb-2">
                <ol class="breadcrumb mb-0" style="font-size:.75rem">
                    <li class="breadcrumb-item">
                        <a href="{{ route('employer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('employees.index') }}">Employees</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Employment Records</li>
                </ol>
            </nav>

            {{-- Employee meta --}}
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
                        &nbsp;·&nbsp;{{ $employee->national_id ?? 'N/A' }}
                    </small>
                </div>
            </div>
        </div>

        <button class="btn btn-accent px-3"
                data-bs-toggle="modal" data-bs-target="#addModal">
            <svg width="15" height="15" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
            </svg>
            Add Record
        </button>
    </div>

    {{-- ── Stats Strip ─────────────────────────────────────── --}}
    @php
        $activeRecord = $records->firstWhere('status', 'active');
        $latestRecord = $records->sortByDesc('start_date')->first();
    @endphp
    <div class="row g-0 border rounded-3 overflow-hidden mb-4 shadow-sm">
        <div class="col border-end p-3">
            <div class="er-stat-label">Total Records</div>
            <div class="er-stat-value" style="color:var(--er-accent)">{{ $records->count() }}</div>
            <div class="er-stat-sub">all time</div>
        </div>
        <div class="col border-end p-3">
            <div class="er-stat-label">Active Position</div>
            <div class="er-stat-value" style="font-size:1rem">{{ $activeRecord?->position ?? '—' }}</div>
            <div class="er-stat-sub">{{ $activeRecord?->department ?? 'No active record' }}</div>
        </div>
        <div class="col border-end p-3">
            <div class="er-stat-label">Tenure</div>
            <div class="er-stat-value">{{ $activeRecord?->duration ?? '—' }}</div>
            <div class="er-stat-sub">current role</div>
        </div>
        <div class="col border-end p-3">
            <div class="er-stat-label">Rehire Eligible</div>
            <div class="er-stat-value"
                 style="color:{{ $latestRecord?->eligible_for_rehire ? 'var(--er-accent)' : '#dc2626' }}">
                {{ is_null($latestRecord?->eligible_for_rehire) ? '—' : ($latestRecord->eligible_for_rehire ? 'Yes' : 'No') }}
            </div>
            <div class="er-stat-sub">latest record</div>
        </div>
        <div class="col p-3">
            <div class="er-stat-label">Last Salary (RWF)</div>
            <div class="er-stat-value" style="font-size:1rem">
                {{ $latestRecord?->salary ? number_format($latestRecord->salary, 0) : '—' }}
            </div>
            <div class="er-stat-sub">per month</div>
        </div>
    </div>

    {{-- ── Records Table Card ───────────────────────────────── --}}
    <div class="card border rounded-3 shadow-sm overflow-hidden">
        <div class="card-header bg-white border-bottom d-flex align-items-center gap-2 py-3 px-4">
            <h2 class="h6 fw-bold mb-0">Employment History</h2>
            <span class="badge bg-light text-secondary border" style="font-size:.7rem">
                {{ $records->count() }} record{{ $records->count() !== 1 ? 's' : '' }}
            </span>
        </div>

        <div class="table-responsive">
            @if($records->isEmpty())
            <div class="d-flex flex-column align-items-center text-center py-5 gap-3">
                <div class="er-empty-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                </div>
                <div>
                    <p class="fw-semibold mb-1">No employment records yet</p>
                    <p class="text-muted small mb-3">Add the first employment record for this employee to get started.</p>
                    <button class="btn btn-accent btn-sm px-3"
                            data-bs-toggle="modal" data-bs-target="#addModal">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                        </svg>
                        Add Record
                    </button>
                </div>
            </div>
            @else
            <table class="table table-hover align-middle mb-0 er-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Position / Dept.</th>
                        <th>Status</th>
                        <th>Period &amp; Duration</th>
                        <th>Salary (RWF)</th>
                        <th>Conduct</th>
                        <th>Rehire</th>
                        <th>Exit Reason</th>
                        <th>Recorded By</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records->sortByDesc('start_date') as $i => $record)
                    <tr>
                        <td class="text-muted" style="font-size:.75rem">{{ $i + 1 }}</td>

                        <td>
                            <div class="fw-semibold">{{ $record->position }}</div>
                            @if($record->department)
                                <div class="pos-dept">{{ $record->department }}</div>
                            @endif
                        </td>

                        <td>
                            @if($record->is_active)
                                <span class="badge-active-er">
                                    <span class="badge-dot"></span>Active
                                </span>
                            @else
                                <span class="badge bg-light text-secondary border" style="font-size:.7rem">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <div style="font-size:.8rem">
                                <span>{{ $record->start_date->format('d M Y') }}</span>
                                <span class="date-sep">→</span>
                                <span class="text-muted">
                                    {{ $record->end_date ? $record->end_date->format('d M Y') : 'Present' }}
                                </span>
                            </div>
                            <div class="date-dur">{{ $record->duration }}</div>
                        </td>

                        <td>
                            <span class="salary-val">{{ number_format($record->salary, 0) }}</span>
                        </td>

                        <td>
                            @if($record->conduct_rating)
                                <span class="badge {{ $record->conduct_badge }}" style="font-size:.7rem">
                                    {{ ucfirst(str_replace('_',' ',$record->conduct_rating)) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>
                            @if(!is_null($record->eligible_for_rehire))
                                <span class="fw-semibold" style="font-size:.82rem;color:{{ $record->eligible_for_rehire ? 'var(--er-accent)' : '#dc2626' }}">
                                    {{ $record->eligible_for_rehire ? 'Yes' : 'No' }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td class="text-muted" style="font-size:.8rem">
                            {{ $record->exit_reason ? $record->exit_reason_label : '—' }}
                        </td>

                        <td class="text-muted" style="font-size:.78rem">
                            {{ $record->recordedBy?->name ?? '—' }}
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('employment-records.show', [$employee, $record]) }}"
                                   class="btn btn-sm btn-outline-secondary" title="View">
                                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"/>
                                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                                <a href="{{ route('employment-records.edit', [$employee, $record]) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z"/>
                                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>{{-- /container-xl --}}


{{-- ══════════════════════════════════════════════════════════
     ADD EMPLOYMENT RECORD MODAL  (pure Bootstrap 5)
══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="addModal" tabindex="-1"
     aria-labelledby="addModalLabel" aria-hidden="true"
     @if($errors->any()) data-bs-show="true" @endif>
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-3 border">

            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold" id="addModalLabel">Add Employment Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('employment-records.store', $employee) }}">
                @csrf
                <input type="hidden" name="employee_id"  value="{{ $employee->id }}">
                <input type="hidden" name="employer_id"  value="{{ auth()->user()->employer->id ?? auth()->id() }}">
                <input type="hidden" name="recorded_by"  value="{{ auth()->id() }}">

                <div class="modal-body px-4 py-3">

                    {{-- ── Role & Department ──────────────────── --}}
                    <div class="form-section-title mb-3">Role &amp; Department</div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold" for="position">
                                Position <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="position" name="position"
                                   class="form-control @error('position') is-invalid @enderror"
                                   placeholder="e.g. Senior Developer"
                                   value="{{ old('position') }}" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold" for="department">Department</label>
                            <input type="text" id="department" name="department"
                                   class="form-control @error('department') is-invalid @enderror"
                                   placeholder="e.g. Engineering"
                                   value="{{ old('department') }}">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold" for="salary">
                                Salary (RWF) <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="salary" name="salary"
                                   min="0" step="0.01"
                                   class="form-control @error('salary') is-invalid @enderror"
                                   placeholder="e.g. 500000"
                                   value="{{ old('salary') }}" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold" for="status">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>
                                <option value="">Select status…</option>
                                <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>Active</option>
                                <option value="inactive"  {{ old('status') === 'inactive'  ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Dates ──────────────────────────────── --}}
                    <div class="form-section-title mt-3 mb-3">Employment Dates</div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold" for="start_date">
                                Start Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6
                            @if(!in_array(old('status'), ['inactive','suspended'])) d-none @endif"
                             id="end-date-group">
                            <label class="form-label small fw-semibold" for="end_date">End Date</label>
                            <input type="date" id="end_date" name="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Exit Info ──────────────────────────── --}}
                    <div id="exit-section"
                         class="@if(!in_array(old('status'), ['inactive','suspended'])) d-none @endif">
                        <div class="form-section-title mt-3 mb-3">Exit Information</div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold" for="exit_reason">Exit Reason</label>
                                <select id="exit_reason" name="exit_reason"
                                        class="form-select @error('exit_reason') is-invalid @enderror">
                                    <option value="">Select reason…</option>
                                    <option value="resigned"         {{ old('exit_reason') === 'resigned'         ? 'selected' : '' }}>Resigned</option>
                                    <option value="terminated"       {{ old('exit_reason') === 'terminated'       ? 'selected' : '' }}>Terminated</option>
                                    <option value="contract_ended"   {{ old('exit_reason') === 'contract_ended'   ? 'selected' : '' }}>Contract Ended</option>
                                    <option value="transferred"      {{ old('exit_reason') === 'transferred'      ? 'selected' : '' }}>Transferred</option>
                                    <option value="retired"          {{ old('exit_reason') === 'retired'          ? 'selected' : '' }}>Retired</option>
                                    <option value="deceased"         {{ old('exit_reason') === 'deceased'         ? 'selected' : '' }}>Deceased</option>
                                    <option value="redundancy"       {{ old('exit_reason') === 'redundancy'       ? 'selected' : '' }}>Redundancy</option>
                                    <option value="mutual_agreement" {{ old('exit_reason') === 'mutual_agreement' ? 'selected' : '' }}>Mutual Agreement</option>
                                    <option value="other"            {{ old('exit_reason') === 'other'            ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('exit_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold" for="exit_details">Exit Details</label>
                                <textarea id="exit_details" name="exit_details" rows="3"
                                          class="form-control @error('exit_details') is-invalid @enderror"
                                          placeholder="Additional context about the departure…">{{ old('exit_details') }}</textarea>
                                @error('exit_details')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── Conduct & Assessment ──────────────── --}}
                    <div class="form-section-title mt-3 mb-3">Conduct &amp; Assessment</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold" for="conduct_rating">Conduct Rating</label>
                            <select id="conduct_rating" name="conduct_rating"
                                    class="form-select @error('conduct_rating') is-invalid @enderror">
                                <option value="">Select rating…</option>
                                <option value="excellent"    {{ old('conduct_rating') === 'excellent'    ? 'selected' : '' }}>Excellent</option>
                                <option value="good"         {{ old('conduct_rating') === 'good'         ? 'selected' : '' }}>Good</option>
                                <option value="satisfactory" {{ old('conduct_rating') === 'satisfactory' ? 'selected' : '' }}>Satisfactory</option>
                                <option value="poor"         {{ old('conduct_rating') === 'poor'         ? 'selected' : '' }}>Poor</option>
                                <option value="very_poor"    {{ old('conduct_rating') === 'very_poor'    ? 'selected' : '' }}>Very Poor</option>
                            </select>
                            @error('conduct_rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 d-flex align-items-end pb-1">
                            <div class="form-check form-switch ms-1">
                                <input type="hidden" name="eligible_for_rehire" value="0">
                                <input class="form-check-input" type="checkbox"
                                       id="eligible_for_rehire" name="eligible_for_rehire" value="1"
                                       {{ old('eligible_for_rehire') ? 'checked' : '' }}
                                       style="width:2.4em;height:1.3em;margin-top:.1em">
                                <label class="form-check-label small fw-semibold ms-1" for="eligible_for_rehire">
                                    Eligible for Rehire
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-semibold" for="conduct_remarks">Conduct Remarks</label>
                            <textarea id="conduct_remarks" name="conduct_remarks" rows="3"
                                      class="form-control @error('conduct_remarks') is-invalid @enderror"
                                      placeholder="Notes on behaviour, performance, or general conduct…">{{ old('conduct_remarks') }}</textarea>
                            @error('conduct_remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>{{-- /modal-body --}}

                <div class="modal-footer border-top px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-accent px-4">
                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                        </svg>
                        Save Record
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- Bootstrap handles modal open/close; only the status toggle needs a tiny script --}}
<script>
    // Show/hide end-date & exit section when status changes
    document.getElementById('status')?.addEventListener('change', function () {
        const inactive = ['inactive', 'suspended'].includes(this.value);
        document.getElementById('end-date-group').classList.toggle('d-none', !inactive);
        document.getElementById('exit-section').classList.toggle('d-none', !inactive);
    });

    // Re-open modal on validation errors (Bootstrap 5)
    @if($errors->any())
        var addModal = new bootstrap.Modal(document.getElementById('addModal'));
        addModal.show();
    @endif
</script>
@endsection