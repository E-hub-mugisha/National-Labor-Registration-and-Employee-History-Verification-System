@extends('layouts.app')
@section('title', 'Feedback Moderation')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Feedback Moderation</h4>
        <small class="text-muted">Review and approve professional feedback</small>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#F8FAFB;font-size:.85rem;">
                <tr>
                    <th class="ps-3">Employee</th>
                    <th>Employer</th>
                    <th>Rating</th>
                    <th>Misconduct</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedback as $item)
                <tr>
                    <td class="ps-3">
                        <div class="fw-medium small">
                            {{ $item->employee->full_name }}
                        </div>
                        <div class="text-muted" style="font-size:.75rem;">
                            {{ $item->employee->masked_national_id }}
                        </div>
                    </td>
                    <td>
                        <small>{{ $item->employer->display_name }}</small>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $item->rating_overall ? '-fill' : '' }} rating-star"
                                   style="font-size:.8rem;"></i>
                            @endfor
                            <small class="text-muted ms-1">
                                {{ $item->rating_overall }}/5
                            </small>
                        </div>
                    </td>
                    <td>
                        @if($item->has_misconduct_flag)
                            <span class="badge badge-rejected">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Flagged
                            </span>
                        @else
                            <span class="text-muted small">None</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $item->created_at->format('d M Y') }}
                        </small>
                    </td>
                    <td>
                        @if($item->moderation_status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($item->moderation_status === 'approved')
                            <span class="badge badge-verified">Approved</span>
                        @elseif($item->moderation_status === 'flagged')
                            <span class="badge badge-rejected">Flagged</span>
                        @else
                            <span class="badge bg-secondary">Removed</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">

                            {{-- View Details --}}
                            <button class="btn btn-outline-secondary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewModal{{ $item->id }}"
                                    title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>

                            @if($item->moderation_status === 'pending')

                                {{-- Approve --}}
                                <form method="POST"
                                      action="{{ route('admin.feedback.moderate', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="approve">
                                    <button class="btn btn-success btn-sm" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>

                                {{-- Remove --}}
                                <form method="POST"
                                      action="{{ route('admin.feedback.moderate', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="remove">
                                    <button class="btn btn-danger btn-sm" title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            @endif
                        </div>

                        {{-- View Details Modal --}}
                        <div class="modal fade"
                             id="viewModal{{ $item->id }}"
                             tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">
                                            Feedback — {{ $item->employee->full_name }}
                                        </h6>
                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">

                                        {{-- Ratings --}}
                                        <div class="row g-3 mb-3">
                                            @foreach([
                                                'Overall'        => 'rating_overall',
                                                'Punctuality'    => 'rating_punctuality',
                                                'Teamwork'       => 'rating_teamwork',
                                                'Communication'  => 'rating_communication',
                                                'Technical'      => 'rating_technical_skills',
                                                'Integrity'      => 'rating_integrity',
                                                'Adaptability'   => 'rating_adaptability',
                                            ] as $label => $field)
                                            <div class="col-md-4">
                                                <small class="text-muted">{{ $label }}</small>
                                                <div>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star{{ $i <= $item->$field ? '-fill' : '' }} rating-star"
                                                           style="font-size:.85rem;"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        {{-- Qualitative --}}
                                        @if($item->strengths)
                                        <div class="mb-2">
                                            <strong class="small">Strengths:</strong>
                                            <p class="small text-muted mb-0">
                                                {{ $item->strengths }}
                                            </p>
                                        </div>
                                        @endif

                                        @if($item->areas_for_improvement)
                                        <div class="mb-2">
                                            <strong class="small">Areas for Improvement:</strong>
                                            <p class="small text-muted mb-0">
                                                {{ $item->areas_for_improvement }}
                                            </p>
                                        </div>
                                        @endif

                                        @if($item->general_comments)
                                        <div class="mb-2">
                                            <strong class="small">General Comments:</strong>
                                            <p class="small text-muted mb-0">
                                                {{ $item->general_comments }}
                                            </p>
                                        </div>
                                        @endif

                                        {{-- Would Rehire --}}
                                        <div class="mb-2">
                                            <strong class="small">Would Rehire:</strong>
                                            <span class="small {{ $item->would_rehire ? 'text-success' : 'text-danger' }}">
                                                {{ $item->would_rehire ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        {{-- Misconduct --}}
                                        @if($item->has_misconduct_flag)
                                        <div class="alert alert-danger small mt-2">
                                            <strong>
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Misconduct:
                                            </strong>
                                            {{ implode(', ', $item->misconduct_categories ?? []) }}
                                            <p class="mb-0 mt-1">
                                                {{ $item->misconduct_details }}
                                            </p>
                                        </div>
                                        @endif

                                    </div>
                                    <div class="modal-footer">
                                        @if($item->moderation_status === 'pending')
                                            <form method="POST"
                                                  action="{{ route('admin.feedback.moderate', $item) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="approve">
                                                <button class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-lg me-1"></i>Approve
                                                </button>
                                            </form>
                                            <form method="POST"
                                                  action="{{ route('admin.feedback.moderate', $item) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="remove">
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash me-1"></i>Remove
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button"
                                                class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-chat-square-text fs-2 d-block mb-2 opacity-25"></i>
                        No feedback pending moderation.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $feedback->links() }}
    </div>
</div>

@endsection