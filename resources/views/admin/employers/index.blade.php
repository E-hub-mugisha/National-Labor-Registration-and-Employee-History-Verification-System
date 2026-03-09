@extends('layouts.app')
@section('title', 'Manage Employers')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Registered Employers</h4>
        <small class="text-muted">All organizations in the national registry</small>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#F8FAFB;font-size:.85rem;">
                <tr>
                    <th class="ps-3">Company</th>
                    <th>RDB Number</th>
                    <th>Industry</th>
                    <th>District</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employers as $employer)
                <tr>
                    <td class="ps-3">
                        <div class="fw-medium small">{{ $employer->company_name }}</div>
                        <div class="text-muted" style="font-size:.75rem;">
                            {{ $employer->user->email }}
                        </div>
                    </td>
                    <td>
                        <code>{{ $employer->rdb_number }}</code>
                    </td>
                    <td>
                        <small>{{ $employer->industry_sector }}</small>
                    </td>
                    <td>
                        <small>{{ $employer->headquarters_district }}</small>
                    </td>
                    <td>
                        @if($employer->verification_status === 'verified')
                            <span class="badge badge-verified">
                                <i class="bi bi-check-circle me-1"></i>Verified
                            </span>
                        @elseif($employer->verification_status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($employer->verification_status === 'rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @else
                            <span class="badge bg-secondary">Suspended</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $employer->created_at->format('d M Y') }}
                        </small>
                    </td>
                    <td>
                        @if($employer->verification_status === 'pending')
                            <div class="d-flex gap-1">

                                {{-- Approve --}}
                                <form method="POST"
                                      action="{{ route('admin.employers.verify', $employer) }}">
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

                            {{-- Reject Modal --}}
                            <div class="modal fade"
                                 id="rejectModal{{ $employer->id }}"
                                 tabindex="-1">
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
                                                          placeholder="Explain why..."></textarea>
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

                        @else
                            <small class="text-muted">—</small>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-building fs-2 d-block mb-2 opacity-25"></i>
                        No employers registered yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $employers->links() }}
    </div>
</div>

@endsection