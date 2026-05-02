@extends('layouts.app')

@section('title', 'Edit Employment Record – ' . $employee->full_name)

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

    .btn-accent {
        background: var(--er-accent); color: #fff; border: none; font-weight: 600;
    }
    .btn-accent:hover, .btn-accent:focus {
        background: var(--er-accent-dim); color: #fff;
        box-shadow: 0 4px 14px var(--er-accent-bg);
    }

    .section-title {
        font-size: .7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .1em; color: var(--er-accent);
        border-bottom: 1px solid #dee2e6; padding-bottom: .4rem;
        margin-bottom: 1.25rem;
    }

    .form-label { font-size: .8rem; font-weight: 600; color: #495057; }

    .form-control:focus, .form-select:focus {
        border-color: var(--er-accent);
        box-shadow: 0 0 0 .2rem rgba(10,143,110,.15);
    }

    .record-id-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        background: #f8f9fa; border: 1px solid #dee2e6;
        border-radius: 6px; padding: .2rem .65rem;
        font-size: .75rem; color: #6c757d;
    }
</style>

<div class="container-xl py-4">

    {{-- ── Alerts ─────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="alert d-flex align-items-center gap-2 mb-4 rounded-3"
         style="background:var(--er-accent-bg);border:1px solid var(--er-accent-bdr);color:var(--er-accent)"
         role="alert">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0">
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('employment-records.show', [$employee, $employmentRecord]) }}">Record #{{ $employmentRecord->id }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h1 class="h4 fw-bold mb-0">Edit Employment Record</h1>
                        <span class="record-id-badge">#{{ $employmentRecord->id }}</span>
                    </div>
                    <small class="text-muted">{{ $employee->full_name }}
                        &nbsp;·&nbsp;
                        <span class="fw-semibold" style="color:var(--er-accent)">
                            {{ $employee->employee_id ?? '#'.$employee->id }}
                        </span>
                    </small>
                </div>
            </div>
        </div>

        <a href="{{ route('employment-records.show', [$employee, $employmentRecord]) }}"
           class="btn btn-outline-secondary btn-sm px-3">
            <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd"/>
            </svg>
            Cancel
        </a>
    </div>

    {{-- ── Form ────────────────────────────────────────────── --}}
    <form method="POST"
          action="{{ route('employment-records.update', [$employee, $employmentRecord]) }}">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- ── Left: main fields ───────────────────────── --}}
            <div class="col-lg-8">

                {{-- Role & Department --}}
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="section-title">Role &amp; Department</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="position">
                                    Position <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="position" name="position"
                                       class="form-control @error('position') is-invalid @enderror"
                                       placeholder="e.g. Senior Developer"
                                       value="{{ old('position', $employmentRecord->position) }}" required>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="department">Department</label>
                                <input type="text" id="department" name="department"
                                       class="form-control @error('department') is-invalid @enderror"
                                       placeholder="e.g. Engineering"
                                       value="{{ old('department', $employmentRecord->department) }}">
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="salary">
                                    Salary (RWF) <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="salary" name="salary"
                                       min="0" step="0.01"
                                       class="form-control @error('salary') is-invalid @enderror"
                                       placeholder="e.g. 500000"
                                       value="{{ old('salary', $employmentRecord->salary) }}" required>
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="status">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        required>
                                    <option value="">Select status…</option>
                                    <option value="active"    {{ old('status', $employmentRecord->status) === 'active'    ? 'selected' : '' }}>Active</option>
                                    <option value="inactive"  {{ old('status', $employmentRecord->status) === 'inactive'  ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ old('status', $employmentRecord->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Employment Dates --}}
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="section-title">Employment Dates</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="start_date">
                                    Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="start_date" name="start_date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date', $employmentRecord->start_date?->format('Y-m-d')) }}"
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6
                                @if(!in_array(old('status', $employmentRecord->status), ['inactive','suspended'])) d-none @endif"
                                 id="end-date-group">
                                <label class="form-label" for="end_date">End Date</label>
                                <input type="date" id="end_date" name="end_date"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       value="{{ old('end_date', $employmentRecord->end_date?->format('Y-m-d')) }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Exit Information --}}
                <div class="card border rounded-3 shadow-sm mb-4
                    @if(!in_array(old('status', $employmentRecord->status), ['inactive','suspended'])) d-none @endif"
                     id="exit-section">
                    <div class="card-body p-4">
                        <div class="section-title">Exit Information</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="exit_reason">Exit Reason</label>
                                <select id="exit_reason" name="exit_reason"
                                        class="form-select @error('exit_reason') is-invalid @enderror">
                                    <option value="">Select reason…</option>
                                    <option value="resigned"         {{ old('exit_reason', $employmentRecord->exit_reason) === 'resigned'         ? 'selected' : '' }}>Resigned</option>
                                    <option value="terminated"       {{ old('exit_reason', $employmentRecord->exit_reason) === 'terminated'       ? 'selected' : '' }}>Terminated</option>
                                    <option value="contract_ended"   {{ old('exit_reason', $employmentRecord->exit_reason) === 'contract_ended'   ? 'selected' : '' }}>Contract Ended</option>
                                    <option value="transferred"      {{ old('exit_reason', $employmentRecord->exit_reason) === 'transferred'      ? 'selected' : '' }}>Transferred</option>
                                    <option value="retired"          {{ old('exit_reason', $employmentRecord->exit_reason) === 'retired'          ? 'selected' : '' }}>Retired</option>
                                    <option value="deceased"         {{ old('exit_reason', $employmentRecord->exit_reason) === 'deceased'         ? 'selected' : '' }}>Deceased</option>
                                    <option value="redundancy"       {{ old('exit_reason', $employmentRecord->exit_reason) === 'redundancy'       ? 'selected' : '' }}>Redundancy</option>
                                    <option value="mutual_agreement" {{ old('exit_reason', $employmentRecord->exit_reason) === 'mutual_agreement' ? 'selected' : '' }}>Mutual Agreement</option>
                                    <option value="other"            {{ old('exit_reason', $employmentRecord->exit_reason) === 'other'            ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('exit_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="exit_details">Exit Details</label>
                                <textarea id="exit_details" name="exit_details" rows="3"
                                          class="form-control @error('exit_details') is-invalid @enderror"
                                          placeholder="Additional context about the departure…">{{ old('exit_details', $employmentRecord->exit_details) }}</textarea>
                                @error('exit_details')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Conduct & Assessment --}}
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="section-title">Conduct &amp; Assessment</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="conduct_rating">Conduct Rating</label>
                                <select id="conduct_rating" name="conduct_rating"
                                        class="form-select @error('conduct_rating') is-invalid @enderror">
                                    <option value="">Select rating…</option>
                                    <option value="excellent"    {{ old('conduct_rating', $employmentRecord->conduct_rating) === 'excellent'    ? 'selected' : '' }}>Excellent</option>
                                    <option value="good"         {{ old('conduct_rating', $employmentRecord->conduct_rating) === 'good'         ? 'selected' : '' }}>Good</option>
                                    <option value="satisfactory" {{ old('conduct_rating', $employmentRecord->conduct_rating) === 'satisfactory' ? 'selected' : '' }}>Satisfactory</option>
                                    <option value="poor"         {{ old('conduct_rating', $employmentRecord->conduct_rating) === 'poor'         ? 'selected' : '' }}>Poor</option>
                                    <option value="very_poor"    {{ old('conduct_rating', $employmentRecord->conduct_rating) === 'very_poor'    ? 'selected' : '' }}>Very Poor</option>
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
                                           {{ old('eligible_for_rehire', $employmentRecord->eligible_for_rehire) ? 'checked' : '' }}
                                           style="width:2.4em;height:1.3em;margin-top:.1em">
                                    <label class="form-check-label small fw-semibold ms-1" for="eligible_for_rehire">
                                        Eligible for Rehire
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="conduct_remarks">Conduct Remarks</label>
                                <textarea id="conduct_remarks" name="conduct_remarks" rows="3"
                                          class="form-control @error('conduct_remarks') is-invalid @enderror"
                                          placeholder="Notes on behaviour, performance, or general conduct…">{{ old('conduct_remarks', $employmentRecord->conduct_remarks) }}</textarea>
                                @error('conduct_remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Right: sidebar ──────────────────────────── --}}
            <div class="col-lg-4">

                {{-- Save Card --}}
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="section-title">Save Changes</div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-accent">
                                <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                </svg>
                                Save Changes
                            </button>
                            <a href="{{ route('employment-records.show', [$employee, $employmentRecord]) }}"
                               class="btn btn-outline-secondary btn-sm">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Record Meta --}}
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="section-title">Record Info</div>
                        <ul class="list-unstyled mb-0" style="font-size:.82rem">
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Record ID</span>
                                <span class="fw-semibold">#{{ $employmentRecord->id }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Recorded By</span>
                                <span>{{ $employmentRecord->recordedBy?->name ?? '—' }}</span>
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

                {{-- Danger Zone --}}
                <div class="card border border-danger-subtle rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <div class="section-title" style="color:#dc2626;border-bottom-color:#fecaca">
                            Danger Zone
                        </div>
                        <p class="text-muted mb-3" style="font-size:.8rem">
                            Permanently delete this employment record. This action cannot be undone.
                        </p>
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

        {{-- Bottom submit bar (sticky on scroll) --}}
        <div class="d-flex justify-content-end gap-2 mt-2 mb-4">
            <a href="{{ route('employment-records.show', [$employee, $employmentRecord]) }}"
               class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-accent px-4">
                <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" class="me-1">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                </svg>
                Save Changes
            </button>
        </div>

    </form>

</div>

<script>
    document.getElementById('status')?.addEventListener('change', function () {
        const inactive = ['inactive', 'suspended'].includes(this.value);
        document.getElementById('end-date-group').classList.toggle('d-none', !inactive);
        document.getElementById('exit-section').classList.toggle('d-none', !inactive);
    });
</script>
@endsection
