@extends('layouts.app')
@section('title', 'Verification Result')

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-10">

        {{-- Profile Header --}}
        <div class="card mb-4"
            style="background:linear-gradient(135deg,#1B3A6B,#2E6DB4);color:#fff;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h4 class="mb-0 fw-bold">{{ $employee->full_name }}</h4>
                            @if($employee->nida_verified)
                            <span style="background:rgba(255,255,255,.15);
                                         padding:3px 10px;border-radius:20px;font-size:.75rem;">
                                <i class="bi bi-patch-check-fill me-1"
                                    style="color:#4CAF50;"></i>NIDA Verified
                            </span>
                            @endif
                        </div>
                        <div style="color:rgba(255,255,255,.8);" class="small">
                            {{ $employee->current_job_title ?? 'No current title' }} ·
                            {{ ucfirst(str_replace('_', ' ', $employee->employment_status)) }}
                        </div>
                        <div style="color:rgba(255,255,255,.6);" class="small mt-1">
                            {{ $employee->district }}, {{ $employee->province }} ·
                            {{ $employee->nationality }}
                        </div>
                    </div>
                    <div class="text-end">
                        @if($employee->average_rating)
                        <div class="fs-3 fw-bold">
                            {{ $employee->average_rating }}
                            <small class="fs-6 opacity-75">/5</small>
                        </div>
                        <div class="small opacity-75">Average Rating</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Search Reference --}}
        <div class="alert mb-4 d-flex gap-2"
            style="background:#E8F5EE;border-left:4px solid #1A7A4A;border-radius:8px;">
            <i class="bi bi-shield-check text-success fs-5 flex-shrink-0 mt-1"></i>
            <div>
                <strong class="text-success">Verified Record</strong>
                <div class="small text-muted">
                    Reference: <code>{{ $log->id }}</code> ·
                    Searched: {{ $log->searched_at ? $log->searched_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} ·
                    Purpose: {{ $log->purpose_label }}
                    @if($log->position_applied_for)
                    · Position: {{ $log->position_applied_for }}
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Employment History --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-briefcase me-2 text-primary"></i>
                            Verified Employment History
                            <span class="badge bg-secondary ms-2">
                                {{ $employee->employmentRecords->count() }} records
                            </span>
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($employee->employmentRecords as $record)
                        <div class="border rounded-3 p-3 mb-3
                                {{ $record->is_current ? 'border-success' : '' }}">

                            {{-- Record Header --}}
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="mb-0 fw-semibold">{{ $record->job_title }}</h6>
                                        @if($record->is_current)
                                        <span class="badge bg-success">Current</span>
                                        @endif
                                    </div>
                                    <div class="fw-medium text-primary small">
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
                                        {{ $record->end_date->format('M Y') }}
                                        @endif
                                    </div>
                                    <div class="text-muted small">{{ $record->duration }}</div>
                                    <span class="badge badge-verified mt-1">
                                        <i class="bi bi-building me-1"></i>Employer Verified
                                    </span>
                                </div>
                            </div>

                            {{-- Exit Reason --}}
                            @if($record->exit_reason && !$record->is_current)
                            <div class="mt-2 pt-2 border-top">
                                <small class="text-muted">
                                    <strong>Exit Reason:</strong>
                                    {{ $record->exit_reason_label }}
                                </small>
                            </div>
                            @endif

                            {{-- Feedback --}}
                            @if($record->feedback && $record->feedback->is_published)
                            <div class="mt-3 pt-3 border-top">
                                <small class="fw-semibold text-muted d-block mb-2">
                                    Professional Assessment
                                </small>
                                <div class="row g-2 mb-2">
                                    @foreach([
                                    'Overall' => 'rating_overall',
                                    'Punctuality' => 'rating_punctuality',
                                    'Teamwork' => 'rating_teamwork',
                                    'Communication' => 'rating_communication',
                                    'Integrity' => 'rating_integrity',
                                    ] as $label => $field)
                                    <div class="col-auto">
                                        <small class="text-muted">{{ $label }}:</small>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $record->feedback->$field ? '-fill' : '' }} rating-star"
                                            style="font-size:.75rem;"></i>
                                            @endfor
                                    </div>
                                    @endforeach
                                </div>

                                @if($record->feedback->strengths)
                                <div class="small mb-1">
                                    <strong>Strengths:</strong>
                                    {{ $record->feedback->strengths }}
                                </div>
                                @endif

                                @if($record->feedback->would_rehire !== null)
                                <div class="small mb-1">
                                    <strong>Would Rehire:</strong>
                                    <span class="{{ $record->feedback->would_rehire ? 'text-success' : 'text-danger' }}">
                                        {{ $record->feedback->would_rehire ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                @endif

                                @if($record->feedback->has_misconduct_flag)
                                <div class="alert alert-danger py-1 px-2 mt-2 mb-0 small">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    <strong>Misconduct Record:</strong>
                                    {{ implode(', ', $record->feedback->misconduct_categories ?? []) }}
                                </div>
                                @endif

                            </div>
                            @endif

                        </div>
                        @empty
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            No verified employment records on file.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Side Panel --}}
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
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">{{ $skill->skill_name }}</span>
                            <span class="badge"
                                style="background:var(--light-blue);color:var(--primary);font-size:.7rem;">
                                {{ ucfirst($skill->proficiency_level) }}
                            </span>
                        </div>
                        @empty
                        <small class="text-muted">No skills listed.</small>
                        @endforelse
                    </div>
                </div>

                {{-- Qualifications --}}
                <div class="card mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="bi bi-mortarboard me-2 text-primary"></i>Qualifications
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($employee->qualifications as $qual)
                        <div class="mb-3">
                            <div class="fw-medium small">{{ $qual->qualification_title }}</div>
                            <div class="text-muted small">{{ $qual->institution_name }}</div>
                            <div class="text-muted small">{{ $qual->duration }}</div>
                        </div>
                        @empty
                        <small class="text-muted">No qualifications listed.</small>
                        @endforelse
                    </div>
                </div>

                {{-- Back Button --}}
                <a href="{{ route('employer.verify.index') }}"
                    class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-2"></i>New Search
                </a>

            </div>
        </div>

    </div>
</div>

@endsection