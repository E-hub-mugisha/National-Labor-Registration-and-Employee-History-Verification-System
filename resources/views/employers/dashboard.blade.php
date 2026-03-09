@extends('layouts.app')
@section('title', 'Employer Dashboard')

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">
            {{ $employer->display_name }}
            @if($employer->verification_status === 'verified')
                <span class="nida-badge ms-2">
                    <i class="bi bi-patch-check-fill me-1"></i>Verified
                </span>
            @else
                <span class="badge badge-pending ms-2">Pending Verification</span>
            @endif
        </h4>
        <small class="text-muted">
            {{ $employer->industry_sector }} ·
            {{ $employer->headquarters_district }},
            {{ $employer->headquarters_province }}
        </small>
    </div>
    <a href="{{ route('employer.verify.index') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-search me-1"></i>Search Employee
    </a>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F0FB;">
                    <i class="bi bi-people-fill text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Active Employees</div>
                    <div class="fw-bold fs-4">{{ $stats['active_employees'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F5EE;">
                    <i class="bi bi-briefcase-fill text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Records</div>
                    <div class="fw-bold fs-4">{{ $stats['total_records'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#FEF3C7;">
                    <i class="bi bi-search text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Searches Used</div>
                    <div class="fw-bold fs-4">{{ $stats['searches_this_month'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F5EE;">
                    <i class="bi bi-arrow-repeat text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Searches Left</div>
                    <div class="fw-bold fs-4">{{ $stats['searches_remaining'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Report New Hire --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-person-plus me-2 text-primary"></i>Report New Hire
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('employer.employment.report') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Employee National ID <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="national_id"
                               class="form-control @error('national_id') is-invalid @enderror"
                               placeholder="e.g. 1199880123456789"
                               required>
                        @error('national_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Job Title <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="job_title"
                               class="form-control @error('job_title') is-invalid @enderror"
                               placeholder="e.g. Software Engineer"
                               required>
                        @error('job_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department</label>
                        <input type="text"
                               name="department"
                               class="form-control"
                               placeholder="e.g. Engineering">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Employment Type <span class="text-danger">*</span>
                        </label>
                        <select name="employment_type" class="form-select" required>
                            <option value="">Select type...</option>
                            <option value="full_time">Full Time</option>
                            <option value="part_time">Part Time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                            <option value="volunteer">Volunteer</option>
                            <option value="attachment">Attachment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Start Date <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="start_date"
                               class="form-control @error('start_date') is-invalid @enderror"
                               required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <label class="form-label fw-semibold">Starting Salary</label>
                            <input type="number"
                                   name="salary_start"
                                   class="form-control"
                                   placeholder="0.00"
                                   step="0.01">
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold">Currency</label>
                            <select name="salary_currency" class="form-select">
                                <option value="RWF">RWF</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-circle me-2"></i>Record Employment
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Recent Employment Records --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>
                    Recent Employment Records
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead style="background:#F8FAFB;font-size:.85rem;">
                        <tr>
                            <th class="ps-3">Employee</th>
                            <th>Job Title</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRecords as $record)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-medium small">
                                    {{ $record->employee?->full_name ?? 'Unknown' }}
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    {{ $record->employee?->masked_national_id }}
                                </div>
                            </td>
                            <td>
                                <small>{{ $record->job_title }}</small>
                            </td>
                            <td>
                                <small>{{ $record->start_date->format('d M Y') }}</small>
                            </td>
                            <td>
                                @if($record->is_current)
                                    <span class="badge badge-verified">Active</span>
                                @else
                                    <span class="badge badge-pending">Exited</span>
                                @endif
                            </td>
                            <td>
                                @if($record->is_current)
                                    <button class="btn btn-outline-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exitModal{{ $record->id }}">
                                        Report Exit
                                    </button>
                                @elseif(!$record->feedback)
                                    <a href="{{ route('employer.feedback.create', $record) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        Add Feedback
                                    </a>
                                @else
                                    <span class="text-muted small">Feedback done</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Exit Modal --}}
                        @if($record->is_current)
                        <div class="modal fade" id="exitModal{{ $record->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">
                                            Report Exit — {{ $record->employee?->full_name }}
                                        </h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST"
                                          action="{{ route('employer.employment.exit', $record) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    End Date <span class="text-danger">*</span>
                                                </label>
                                                <input type="date"
                                                       name="end_date"
                                                       class="form-control"
                                                       required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    Exit Reason <span class="text-danger">*</span>
                                                </label>
                                                <select name="exit_reason"
                                                        class="form-select"
                                                        required>
                                                    <option value="">Select reason...</option>
                                                    <option value="resignation">Resignation</option>
                                                    <option value="contract_expiry">Contract Expiry</option>
                                                    <option value="mutual_agreement">Mutual Agreement</option>
                                                    <option value="redundancy">Redundancy</option>
                                                    <option value="dismissal_misconduct">Dismissal — Misconduct</option>
                                                    <option value="dismissal_performance">Dismissal — Performance</option>
                                                    <option value="medical_grounds">Medical Grounds</option>
                                                    <option value="retirement">Retirement</option>
                                                    <option value="death">Death</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    Exit Details
                                                </label>
                                                <textarea name="exit_details"
                                                          class="form-control"
                                                          rows="3"
                                                          placeholder="Required for dismissal categories..."></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    Reference Number
                                                </label>
                                                <input type="text"
                                                       name="exit_reference_number"
                                                       class="form-control"
                                                       placeholder="Optional">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Confirm Exit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>
                                No employment records yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection