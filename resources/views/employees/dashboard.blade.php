@extends('layouts.app')
@section('title', 'Employee Dashboard')

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">
            Welcome, {{ $employee->first_name }}
            @if($employee->nida_verified)
                <span class="nida-badge ms-2">
                    <i class="bi bi-patch-check-fill me-1"></i>NIDA Verified
                </span>
            @endif
        </h4>
        <small class="text-muted">
            {{ $employee->masked_national_id }} ·
            {{ ucfirst($employee->employment_status) }}
        </small>
    </div>
    <a href="{{ route('employee.profile.edit') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-pencil me-1"></i>Edit Profile
    </a>
</div>

{{-- Profile Incomplete Warning --}}
@if(!$employee->profile_complete)
<div class="alert alert-warning d-flex align-items-center mb-4">
    <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
    <div>
        <strong>Complete your profile</strong> to appear in employer search results.
        <a href="{{ route('employee.profile.edit') }}" class="alert-link ms-1">
            Complete now →
        </a>
    </div>
</div>
@endif

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F0FB;">
                    <i class="bi bi-briefcase-fill text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Experience</div>
                    <div class="fw-bold fs-4">
                        {{ $stats['total_experience'] }}
                        <small class="fs-6 text-muted">yrs</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F5EE;">
                    <i class="bi bi-building-fill text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Employers</div>
                    <div class="fw-bold fs-4">{{ $stats['total_employers'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#FEF3C7;">
                    <i class="bi bi-star-fill text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Avg Rating</div>
                    <div class="fw-bold fs-4">
                        {{ $stats['avg_rating'] ?? 'N/A' }}
                        @if($stats['avg_rating'])
                            <small class="fs-6 text-muted">/5</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#FEE2E2;">
                    <i class="bi bi-eye-fill text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Profile Views</div>
                    <div class="fw-bold fs-4">{{ $stats['profile_views'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Employment History --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>
                    Employment History
                </h6>
            </div>
            <div class="card-body">
                @forelse($employee->employmentRecords as $record)
                <div class="timeline-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $record->job_title }}</h6>
                            <div class="text-muted small">
                                {{ $record->employer?->display_name ?? 'Unknown Employer' }} ·
                                {{ ucfirst(str_replace('_', ' ', $record->employment_type)) }}
                            </div>
                            <div class="text-muted small mt-1">
                                {{ $record->start_date->format('M Y') }} —
                                @if($record->is_current)
                                    <span class="text-success fw-semibold">Present</span>
                                @else
                                    {{ $record->end_date->format('M Y') }}
                                @endif
                                <span class="ms-2">({{ $record->duration }})</span>
                            </div>
                        </div>
                        <div class="text-end">
                            @if($record->employer_verified)
                                <span class="badge badge-verified">
                                    <i class="bi bi-check-circle me-1"></i>Verified
                                </span>
                            @else
                                <span class="badge badge-pending">Self-reported</span>
                            @endif
                            @if($record->feedback && $record->feedback->is_published)
                                <div class="mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $record->feedback->rating_overall ? '-fill' : '' }} rating-star"
                                           style="font-size:.8rem;"></i>
                                    @endfor
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-briefcase fs-1 d-block mb-2 opacity-25"></i>
                        No employment history yet.
                        <a href="{{ route('employee.profile.edit') }}">Add your work history →</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">

        {{-- Skills --}}
        <div class="card mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-tools me-2 text-primary"></i>Skills
                </h6>
            </div>
            <div class="card-body">
                @forelse($employee->skills as $skill)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-medium">{{ $skill->skill_name }}</span>
                        <span class="badge" style="background:var(--light-blue);color:var(--primary);">
                            {{ ucfirst($skill->proficiency_level) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted small mb-2">No skills added yet.</p>
                @endforelse
                <a href="{{ route('employee.profile.edit') }}" class="btn btn-outline-primary btn-sm w-100 mt-2">
                    <i class="bi bi-plus me-1"></i>Add Skill
                </a>
            </div>
        </div>

        {{-- Profile Visibility --}}
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-eye me-2 text-primary"></i>Profile Visibility
                </h6>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="small">Searchable by employers</span>
                    <span class="badge {{ $employee->is_searchable ? 'bg-success' : 'bg-secondary' }}">
                        {{ $employee->is_searchable ? 'Visible' : 'Hidden' }}
                    </span>
                </div>
                <form method="POST" action="{{ route('employee.toggle-searchable') }}">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm w-100 {{ $employee->is_searchable ? 'btn-outline-danger' : 'btn-success' }}">
                        {{ $employee->is_searchable ? 'Hide from Search' : 'Make Visible' }}
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection