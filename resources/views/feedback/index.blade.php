@extends('layouts.app')
@section('title', 'My Feedback')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">My Professional Feedback</h4>
        <small class="text-muted">Feedback submitted by your past employers</small>
    </div>
</div>

{{-- Summary Cards --}}
@if($feedback->count())
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F0FB;">
                    <i class="bi bi-star-fill text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Average Rating</div>
                    <div class="fw-bold fs-4">
                        {{ number_format($feedback->where('moderation_status','approved')->avg('rating_overall'), 1) }}
                        <small class="fs-6 text-muted">/5</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F5EE;">
                    <i class="bi bi-chat-square-text-fill text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Feedback</div>
                    <div class="fw-bold fs-4">{{ $feedback->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#E8F5EE;">
                    <i class="bi bi-hand-thumbs-up-fill text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Would Rehire</div>
                    <div class="fw-bold fs-4">
                        {{ $feedback->where('would_rehire', true)->count() }}
                        <small class="fs-6 text-muted">
                            / {{ $feedback->count() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#FEE2E2;">
                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Misconduct Flags</div>
                    <div class="fw-bold fs-4">
                        {{ $feedback->where('has_misconduct_flag', true)->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Feedback List --}}
@forelse($feedback as $item)
<div class="card mb-4">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h6 class="mb-0 fw-bold">
                    {{ $item->employmentRecord->job_title ?? 'Employment Record' }}
                </h6>
                <small class="text-muted">
                    {{ $item->employer->display_name }} ·
                    {{ $item->employmentRecord->start_date->format('M Y') }} —
                    {{ $item->employmentRecord->end_date?->format('M Y') ?? 'Present' }}
                </small>
            </div>
            <div class="d-flex gap-2 align-items-center">
                @if($item->moderation_status === 'approved')
                    <span class="badge badge-verified">
                        <i class="bi bi-check-circle me-1"></i>Published
                    </span>
                @elseif($item->moderation_status === 'pending')
                    <span class="badge badge-pending">
                        <i class="bi bi-hourglass me-1"></i>Under Review
                    </span>
                @elseif($item->moderation_status === 'flagged')
                    <span class="badge badge-rejected">
                        <i class="bi bi-flag me-1"></i>Flagged
                    </span>
                @else
                    <span class="badge bg-secondary">Removed</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row g-4">

            {{-- Ratings --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <small class="fw-semibold text-muted text-uppercase"
                           style="font-size:.72rem;letter-spacing:.05em;">
                        Performance Ratings
                    </small>
                </div>
                @foreach([
                    'Overall'        => 'rating_overall',
                    'Punctuality'    => 'rating_punctuality',
                    'Teamwork'       => 'rating_teamwork',
                    'Communication'  => 'rating_communication',
                    'Technical'      => 'rating_technical_skills',
                    'Integrity'      => 'rating_integrity',
                    'Adaptability'   => 'rating_adaptability',
                ] as $label => $field)
                @if($item->$field)
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <small class="text-muted" style="width:110px;">{{ $label }}</small>
                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                        <div class="flex-grow-1"
                             style="background:#F0F0F0;border-radius:4px;height:6px;">
                            <div style="width:{{ ($item->$field / 5) * 100 }}%;
                                        background:{{ $item->$field >= 4 ? '#1A7A4A' : ($item->$field >= 3 ? '#2E6DB4' : '#DC2626') }};
                                        border-radius:4px;height:6px;">
                            </div>
                        </div>
                        <small class="fw-bold" style="width:20px;">{{ $item->$field }}</small>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            {{-- Qualitative --}}
            <div class="col-lg-6">

                {{-- Would Rehire --}}
                <div class="mb-3 p-3 rounded"
                     style="background:{{ $item->would_rehire ? '#E8F5EE' : '#FEE2E2' }};">
                    <small class="fw-semibold">Would Rehire:</small>
                    <span class="ms-2 fw-bold
                        {{ $item->would_rehire ? 'text-success' : 'text-danger' }}">
                        {{ $item->would_rehire ? 'Yes' : 'No' }}
                    </span>
                    @if($item->rehire_condition)
                        <div class="text-muted small mt-1">
                            Condition: {{ $item->rehire_condition }}
                        </div>
                    @endif
                </div>

                @if($item->strengths)
                <div class="mb-2">
                    <small class="fw-semibold text-muted">Strengths:</small>
                    <p class="small mb-0">{{ $item->strengths }}</p>
                </div>
                @endif

                @if($item->areas_for_improvement)
                <div class="mb-2">
                    <small class="fw-semibold text-muted">Areas for Improvement:</small>
                    <p class="small mb-0">{{ $item->areas_for_improvement }}</p>
                </div>
                @endif

                @if($item->general_comments)
                <div class="mb-2">
                    <small class="fw-semibold text-muted">General Comments:</small>
                    <p class="small mb-0">{{ $item->general_comments }}</p>
                </div>
                @endif

                {{-- Misconduct --}}
                @if($item->has_misconduct_flag)
                <div class="alert alert-danger py-2 px-3 small mt-2">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <strong>Misconduct Flag:</strong>
                    {{ implode(', ', $item->misconduct_categories ?? []) }}
                </div>
                @endif

            </div>
        </div>

        {{-- Employee Response --}}
        @if($item->employee_response)
        <div class="mt-3 pt-3 border-top">
            <small class="fw-semibold text-muted d-block mb-1">
                <i class="bi bi-reply me-1"></i>Your Response:
            </small>
            <p class="small mb-0 text-muted">{{ $item->employee_response }}</p>
        </div>
        @endif

        {{-- Respond Button --}}
        @if($item->moderation_status === 'approved' && !$item->employee_response)
        <div class="mt-3 pt-3 border-top">
            <button class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="collapse"
                    data-bs-target="#respondForm{{ $item->id }}">
                <i class="bi bi-reply me-1"></i>Respond to Feedback
            </button>
            <div class="collapse mt-3" id="respondForm{{ $item->id }}">
                <form method="POST"
                      action="{{ route('employee.feedback.respond', $item) }}">
                    @csrf
                    @method('PATCH')
                    <textarea name="employee_response"
                              class="form-control mb-2"
                              rows="3"
                              placeholder="Write your professional response..."
                              required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-send me-1"></i>Submit Response
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>
@empty
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-star fs-1 d-block mb-3 opacity-25"></i>
        <h5 class="text-muted">No Feedback Yet</h5>
        <p class="text-muted small">
            Feedback will appear here once your past employers submit their assessments.
        </p>
        <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-primary">
            <i class="bi bi-speedometer2 me-1"></i>Back to Dashboard
        </a>
    </div>
</div>
@endforelse

@endsection