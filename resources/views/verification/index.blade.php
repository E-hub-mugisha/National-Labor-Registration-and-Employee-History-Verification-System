@extends('layouts.app')
@section('title', 'Verification Portal')

@section('content')

<div class="row justify-content-center">
<div class="col-xl-10">

    <div class="section-header mb-4">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-search me-2"></i>Employee History Verification Portal
        </h5>
        <small class="text-muted">Search verified employment records using National ID</small>
    </div>

    {{-- Quota Info --}}
    <div class="card mb-4" style="background:var(--light-blue);border:none;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <strong class="text-primary">{{ $employer->display_name }}</strong>
                    <span class="badge badge-verified ms-2">
                        <i class="bi bi-patch-check-fill me-1"></i>Verified Employer
                    </span>
                </div>
                <div class="col-auto d-flex align-items-center gap-3">
                    <div class="text-muted small">
                        <i class="bi bi-search me-1"></i>
                        <strong class="text-primary">{{ $employer->remaining_search_quota }}</strong>
                        searches remaining this month
                    </div>
                    <span class="badge" style="background:var(--primary);">
                        {{ ucfirst($employer->subscription_tier) }} Plan
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Form --}}
    <div class="card mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-person-search me-2 text-primary"></i>Search by National ID
            </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('employer.verify.search') }}">
                @csrf
                <div class="row g-3">

                    {{-- National ID --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            National ID Number <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-credit-card-2-front"></i>
                            </span>
                            <input type="text"
                                   name="national_id"
                                   class="form-control @error('national_id') is-invalid @enderror"
                                   placeholder="e.g. 1199880123456789"
                                   maxlength="20"
                                   value="{{ old('national_id') }}"
                                   required>
                            @error('national_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">16-digit Rwanda National ID</small>
                    </div>

                    {{-- Purpose --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Purpose of Search <span class="text-danger">*</span>
                        </label>
                        <select name="purpose"
                                class="form-select @error('purpose') is-invalid @enderror"
                                required>
                            <option value="">Select purpose...</option>
                            <option value="pre_employment_check"    {{ old('purpose') === 'pre_employment_check'    ? 'selected' : '' }}>Pre-Employment Check</option>
                            <option value="background_verification" {{ old('purpose') === 'background_verification' ? 'selected' : '' }}>Background Verification</option>
                            <option value="contract_renewal"        {{ old('purpose') === 'contract_renewal'        ? 'selected' : '' }}>Contract Renewal</option>
                            <option value="security_clearance"      {{ old('purpose') === 'security_clearance'      ? 'selected' : '' }}>Security Clearance</option>
                            <option value="other"                   {{ old('purpose') === 'other'                   ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Position --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Position Applied For</label>
                        <input type="text"
                               name="position_applied_for"
                               class="form-control"
                               placeholder="e.g. Senior Accountant"
                               value="{{ old('position_applied_for') }}">
                    </div>

                </div>

                {{-- Data Protection Notice --}}
                <div class="mt-3 p-3 rounded"
                     style="background:#FFF9E6;border:1px solid #F59E0B;">
                    <small>
                        <i class="bi bi-info-circle me-1 text-warning"></i>
                        <strong>Data Protection Notice:</strong>
                        All searches are logged and audited. This information is
                        provided solely for legitimate employment verification purposes
                        under Rwanda's Data Protection Law. Misuse may result in
                        legal penalties.
                    </small>
                </div>

                <div class="mt-3">
                    <button type="submit"
                            class="btn btn-primary px-4"
                            @if($employer->remaining_search_quota <= 0) disabled @endif>
                        <i class="bi bi-search me-2"></i>Search Registry
                    </button>
                    @if($employer->remaining_search_quota <= 0)
                        <span class="text-danger ms-3 small">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Monthly quota exhausted.
                        </span>
                    @endif
                </div>

            </form>
        </div>
    </div>

    {{-- Recent Searches --}}
    @if($recentSearches->count())
    <div class="card">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-clock-history me-2 text-primary"></i>Recent Searches
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead style="background:#F8FAFB;font-size:.85rem;">
                    <tr>
                        <th class="ps-3">National ID</th>
                        <th>Result</th>
                        <th>Purpose</th>
                        <th>Position</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSearches as $search)
                    <tr>
                        <td class="ps-3">
                            <code>{{ $search->masked_national_id }}</code>
                        </td>
                        <td>
                            @if($search->employee_found)
                                <span class="badge badge-verified">
                                    <i class="bi bi-check-circle me-1"></i>Found
                                </span>
                            @else
                                <span class="badge bg-secondary">Not Found</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $search->purpose_label }}</small>
                        </td>
                        <td>
                            <small>{{ $search->position_applied_for ?? '—' }}</small>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $search->searched_at->diffForHumans() }}
                            </small>
                        </td>
                        <td>
                            @if($search->employee_found && $search->employee)
                                <a href="{{ route('employer.verify.profile', $search->employee) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    View
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
</div>

@endsection
