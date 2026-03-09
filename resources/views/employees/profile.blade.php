@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

<div class="row justify-content-center">
<div class="col-xl-10">

    {{-- Profile Header --}}
    <div class="card mb-4"
         style="background:linear-gradient(135deg,#1B3A6B,#2E6DB4);color:#fff;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                <div class="d-flex align-items-center gap-4">
                    {{-- Avatar --}}
                    <div style="width:80px;height:80px;background:rgba(255,255,255,.15);
                                border-radius:50%;display:flex;align-items:center;
                                justify-content:center;font-size:2rem;flex-shrink:0;">
                        {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                    </div>

                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <h4 class="mb-0 fw-bold">{{ $employee->full_name }}</h4>
                            @if($employee->nida_verified)
                                <span style="background:rgba(255,255,255,.15);
                                             padding:3px 10px;border-radius:20px;
                                             font-size:.75rem;">
                                    <i class="bi bi-patch-check-fill me-1"
                                       style="color:#4CAF50;"></i>NIDA Verified
                                </span>
                            @endif
                        </div>
                        <div style="color:rgba(255,255,255,.8);" class="small mb-1">
                            {{ $employee->current_job_title ?? 'No current title' }}
                        </div>
                        <div style="color:rgba(255,255,255,.65);" class="small">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $employee->district ?? '—' }},
                            {{ $employee->province ?? '—' }}
                            @if($employee->phone_primary)
                                · <i class="bi bi-telephone me-1"></i>
                                {{ $employee->phone_primary }}
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Rating + Edit --}}
                <div class="text-end">
                    @if($employee->average_rating)
                        <div class="fs-3 fw-bold">
                            {{ $employee->average_rating }}
                            <small class="fs-6 opacity-75">/5</small>
                        </div>
                        <div class="small opacity-75 mb-2">Average Rating</div>
                    @endif
                    <a href="{{ route('employee.profile.edit') }}"
                       class="btn btn-sm"
                       style="background:rgba(255,255,255,.2);color:#fff;border:1px solid rgba(255,255,255,.3);">
                        <i class="bi bi-pencil me-1"></i>Edit Profile
                    </a>
                </div>

            </div>

            {{-- Status Badges --}}
            <div class="d-flex gap-2 mt-3 flex-wrap">
                <span style="background:rgba(255,255,255,.15);padding:4px 12px;
                             border-radius:20px;font-size:.78rem;">
                    <i class="bi bi-briefcase me-1"></i>
                    {{ ucfirst(str_replace('_', ' ', $employee->employment_status)) }}
                </span>
                <span style="background:rgba(255,255,255,.15);padding:4px 12px;
                             border-radius:20px;font-size:.78rem;">
                    <i class="bi bi-eye me-1"></i>
                    {{ $employee->is_searchable ? 'Visible to Employers' : 'Hidden' }}
                </span>
                @if($employee->total_experience_years > 0)
                <span style="background:rgba(255,255,255,.15);padding:4px 12px;
                             border-radius:20px;font-size:.78rem;">
                    <i class="bi bi-clock me-1"></i>
                    {{ $employee->total_experience_years }} yrs experience
                </span>
                @endif
            </div>

        </div>
    </div>

    <div class="row g-4">

        {{-- Left Column --}}
        <div class="col-lg-8">

            {{-- Professional Summary --}}
            @if($employee->professional_summary)
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-file-person me-2 text-primary"></i>
                        Professional Summary
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-muted">{{ $employee->professional_summary }}</p>
                </div>
            </div>
            @endif

            {{-- Employment History --}}
            <div class="card mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-briefcase me-2 text-primary"></i>
                        Employment History
                        <span class="badge bg-secondary ms-2">
                            {{ $employee->employmentRecords->count() }}
                        </span>
                    </h6>
                </div>
                <div class="card-body">
                    @forelse($employee->employmentRecords()->orderBy('start_date','desc')->get() as $record)
                    <div class="timeline-item
                                {{ $record->is_current ? 'border-start border-success border-3' : '' }}
                                ps-3 mb-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h6 class="mb-0 fw-semibold">{{ $record->job_title }}</h6>
                                    @if($record->is_current)
                                        <span class="badge bg-success">Current</span>
                                    @endif
                                </div>
                                <div class="text-primary fw-medium small">
                                    {{ $record->employer?->display_name ?? 'On record' }}
                                </div>
                                <div class="text-muted small">
                                    {{ $record->department ? $record->department . ' · ' : '' }}
                                    {{ ucfirst(str_replace('_', ' ', $record->employment_type)) }}
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="small fw-medium">
                                    {{ $record->start_date->format('M Y') }} —
                                    @if($record->is_current)
                                        <span class="text-success">Present</span>
                                    @else
                                        {{ $record->end_date?->format('M Y') }}
                                    @endif
                                </div>
                                <div class="text-muted small">{{ $record->duration }}</div>
                                @if($record->employer_verified)
                                    <span class="badge badge-verified mt-1">
                                        <i class="bi bi-check-circle me-1"></i>Verified
                                    </span>
                                @else
                                    <span class="badge badge-pending mt-1">Self-reported</span>
                                @endif
                            </div>
                        </div>

                        {{-- Feedback Preview --}}
                        @if($record->feedback && $record->feedback->moderation_status === 'approved')
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-muted fw-semibold">Employer Assessment: </small>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $record->feedback->rating_overall ? '-fill' : '' }} rating-star"
                                   style="font-size:.8rem;"></i>
                            @endfor
                            <small class="text-muted ms-1">
                                {{ $record->feedback->rating_overall }}/5
                            </small>
                        </div>
                        @endif

                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-briefcase fs-2 d-block mb-2 opacity-25"></i>
                        No employment history yet.
                        <a href="{{ route('employee.profile.edit') }}" class="d-block mt-1">
                            Complete your profile →
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Qualifications --}}
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-mortarboard me-2 text-primary"></i>
                        Qualifications
                    </h6>
                </div>
                <div class="card-body">
                    @forelse($employee->qualifications as $qual)
                    <div class="d-flex gap-3 mb-3">
                        <div style="width:44px;height:44px;background:var(--light-blue);
                                    border-radius:10px;display:flex;align-items:center;
                                    justify-content:center;flex-shrink:0;">
                            <i class="bi bi-award text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small">{{ $qual->qualification_title }}</div>
                            <div class="text-muted small">{{ $qual->institution_name }}</div>
                            <div class="text-muted small">{{ $qual->duration }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted small mb-0">No qualifications added yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Right Column --}}
        <div class="col-lg-4">

            {{-- Personal Details --}}
            <div class="card mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Personal Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">National ID</small>
                        <div class="fw-medium small">
                            {{ $employee->masked_national_id }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Date of Birth</small>
                        <div class="fw-medium small">
                            {{ $employee->date_of_birth?->format('d M Y') ?? '—' }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Gender</small>
                        <div class="fw-medium small">
                            {{ ucfirst($employee->gender ?? '—') }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Nationality</small>
                        <div class="fw-medium small">
                            {{ $employee->nationality ?? '—' }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Email</small>
                        <div class="fw-medium small">
                            {{ $employee->personal_email ?? Auth::user()->email }}
                        </div>
                    </div>
                </div>
            </div>

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
                        <span class="small">{{ $skill->skill_name }}</span>
                        <span class="badge"
                              style="background:var(--light-blue);color:var(--primary);font-size:.7rem;">
                            {{ ucfirst($skill->proficiency_level) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-muted small mb-0">No skills added yet.</p>
                    @endforelse
                    <a href="{{ route('employee.profile.edit') }}"
                       class="btn btn-outline-primary btn-sm w-100 mt-3">
                        <i class="bi bi-pencil me-1"></i>Edit Skills
                    </a>
                </div>
            </div>

            {{-- Profile Visibility --}}
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-eye me-2 text-primary"></i>
                        Profile Visibility
                    </h6>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small">Searchable by employers</span>
                        <span class="badge {{ $employee->is_searchable ? 'bg-success' : 'bg-secondary' }}">
                            {{ $employee->is_searchable ? 'Visible' : 'Hidden' }}
                        </span>
                    </div>
                    <form method="POST"
                          action="{{ route('employee.toggle-searchable') }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm w-100
                            {{ $employee->is_searchable
                                ? 'btn-outline-danger'
                                : 'btn-success' }}">
                            {{ $employee->is_searchable
                                ? 'Hide from Search'
                                : 'Make Visible' }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
</div>

@endsection
