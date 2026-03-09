@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">System Dashboard</h4>
        <small class="text-muted">
            National Labor Registration & Verification System — Rwanda
        </small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.statistics') }}"
           class="btn btn-outline-primary btn-sm">
            <i class="bi bi-bar-chart me-1"></i>Statistics
        </a>
        <a href="{{ route('admin.audit-log') }}"
           class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-journal-text me-1"></i>Audit Log
        </a>
    </div>
</div>

{{-- Stats Grid --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-start gap-3">
                <div class="stat-icon" style="background:#E8F0FB;">
                    <i class="bi bi-people-fill text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Registered Employees</div>
                    <div class="fw-bold fs-4">{{ number_format($stats['total_employees']) }}</div>
                    <div class="text-muted" style="font-size:.75rem;">
                        {{ number_format($stats['verified_employees']) }} NIDA Verified
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-start gap-3">
                <div class="stat-icon" style="background:#E8F5EE;">
                    <i class="bi bi-building-fill text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Active Employers</div>
                    <div class="fw-bold fs-4">{{ number_format($stats['verified_employers']) }}</div>
                    <div class="text-muted" style="font-size:.75rem;">
                        {{ number_format($stats['pending_employers']) }} Pending Review
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-start gap-3">
                <div class="stat-icon" style="background:#FEF3C7;">
                    <i class="bi bi-briefcase-fill text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Employment Records</div>
                    <div class="fw-bold fs-4">{{ number_format($stats['total_records']) }}</div>
                    <div class="text-muted" style="font-size:.75rem;">
                        Across all organizations
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-start gap-3">
                <div class="stat-icon" style="background:#FEE2E2;">
                    <i class="bi bi-flag-fill text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Pending Moderation</div>
                    <div class="fw-bold fs-4">{{ number_format($stats['pending_moderation']) }}</div>
                    <div class="text-muted" style="font-size:.75rem;">
                        Feedback awaiting review
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="card stat-card p-3 h-100">
            <div class="d-flex align-items-start gap-3">
                <div class="stat-icon" style="background:#F3E8FF;">
                    <i class="bi bi-search" style="color:#7C3AED;"></i>
                </div>
                <div>
                    <div class="text-muted small">Searches Today</div>
                    <div class="fw-bold fs-4">{{ number_format($stats['searches_today']) }}</div>
                    <div class="text-muted" style="font-size:.75rem;">
                        {{ number_format($stats['searches_this_month']) }} this month
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Pending Employer Verifications --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-building me-2 text-warning"></i>
                    Pending Employer Verifications
                    @if($stats['pending_employers'])
                        <span class="badge badge-pending ms-1">
                            {{ $stats['pending_employers'] }}
                        </span>
                    @endif
                </h6>
                <a href="{{ route('admin.employers.index') }}"
                   class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($pendingEmployers as $employer)
                <div class="d-flex align-items-center p-3 border-bottom gap-3">
                    <div class="flex-grow-1">
                        <div class="fw-medium small">{{ $employer->company_name }}</div>
                        <div class="text-muted" style="font-size:.78rem;">
                            RDB: <code>{{ $employer->rdb_number }}</code> ·
                            {{ $employer->industry_sector }} ·
                            {{ $employer->headquarters_district }}
                        </div>
                        <div class="text-muted" style="font-size:.75rem;">
                            Registered {{ $employer->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="d-flex gap-1">

                        {{-- Approve --}}
                        <form method="POST"
                              action="{{ route('admin.employers.verify', $employer) }}"
                              class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="verify">
                            <button class="btn btn-success btn-sm" title="Approve">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>

                        {{-- Reject --}}
                        <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#rejectModal{{ $employer->id }}"
                                title="Reject">
                            <i class="bi bi-x-lg"></i>
                        </button>

                    </div>
                </div>

                {{-- Reject Modal --}}
                <div class="modal fade" id="rejectModal{{ $employer->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">
                                    Reject: {{ $employer->company_name }}
                                </h6>
                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST"
                                  action="{{ route('admin.employers.verify', $employer) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="reject">
                                <div class="modal-body">
                                    <label class="form-label fw-semibold">
                                        Reason for Rejection
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="rejection_reason"
                                              class="form-control"
                                              rows="3"
                                              required
                                              placeholder="Explain why this registration is being rejected..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Confirm Rejection
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle-fill text-success fs-2 d-block mb-2"></i>
                    No pending verifications.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Pending Feedback Moderation --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-chat-square-text me-2 text-danger"></i>
                    Feedback Pending Moderation
                    @if($stats['pending_moderation'])
                        <span class="badge badge-pending ms-1">
                            {{ $stats['pending_moderation'] }}
                        </span>
                    @endif
                </h6>
                <a href="{{ route('admin.feedback.index') }}"
                   class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($pendingFeedback as $feedback)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-medium small">
                                {{ $feedback->employee->full_name }}
                            </div>
                            <div class="text-muted" style="font-size:.78rem;">
                                From: {{ $feedback->employer->display_name }} ·
                                Rating: {{ $feedback->rating_overall }}/5
                            </div>
                            @if($feedback->has_misconduct_flag)
                            <span class="badge badge-rejected mt-1">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Misconduct Flag
                            </span>
                            @endif
                        </div>
                        <div class="d-flex gap-1">

                            {{-- Approve --}}
                            <form method="POST"
                                  action="{{ route('admin.feedback.moderate', $feedback) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="approve">
                                <button class="btn btn-success btn-sm" title="Approve">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>

                            {{-- Remove --}}
                            <form method="POST"
                                  action="{{ route('admin.feedback.moderate', $feedback) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="remove">
                                <button class="btn btn-danger btn-sm" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle-fill text-success fs-2 d-block mb-2"></i>
                    No feedback awaiting moderation.
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection