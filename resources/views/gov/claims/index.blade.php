@extends('layouts.app')

@section('title', 'Claims Review')

@section('content')

<div class="page-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('gov.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Claims</li>
            </ol>
        </nav>
        <h1 class="page-title">Claims Review</h1>
        <p class="page-subtitle">Review and respond to employee claims</p>
    </div>
    <span class="badge-pending" style="font-size:.8rem;padding:6px 14px;">
        {{ $claims->total() }} total
    </span>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-flag text-danger"></i>
        <span class="card-header-title">All Claims</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Claim</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ optional($claim->employee)->name ?? 'Unknown' }}</div>
                            <div class="text-muted" style="font-size:.75rem;">
                                {{ optional($claim->employee)->email ?? '' }}
                            </div>
                        </td>
                        <td style="max-width:280px;">
                            <div style="font-size:.83rem;">
                                {{ Str::limit($claim->description ?? $claim->body ?? '—', 80) }}
                            </div>
                            @if($claim->type ?? null)
                                <span class="badge-pending" style="font-size:.65rem;">{{ $claim->type }}</span>
                            @endif
                        </td>
                        <td style="font-size:.8rem;color:var(--slate-400);">
                            {{ $claim->created_at->format('d M Y') }}<br>
                            <span style="font-size:.72rem;">{{ $claim->created_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            @if($claim->status === 'resolved')
                                <span class="badge-verified">Resolved</span>
                            @elseif($claim->status === 'pending')
                                <span class="badge-pending">Pending</span>
                            @else
                                <span class="badge-rejected">{{ ucfirst($claim->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($claim->status !== 'resolved')
                            <button type="button" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#resolveModal{{ $claim->id }}">
                                <i class="bi bi-check2-circle me-1"></i>Resolve
                            </button>
                            @else
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#resolveModal{{ $claim->id }}">
                                <i class="bi bi-eye me-1"></i>View Response
                            </button>
                            @endif
                        </td>
                    </tr>

                    {{-- Resolve Modal --}}
                    <div class="modal fade" id="resolveModal{{ $claim->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content" style="border-radius:var(--radius-lg);border:1px solid var(--slate-200);">
                                <div class="modal-header" style="border-color:var(--slate-200);">
                                    <h5 class="modal-title" style="font-size:.95rem;font-weight:700;">
                                        {{ $claim->status === 'resolved' ? 'Claim Response' : 'Resolve Claim' }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">

                                    {{-- Claim detail --}}
                                    <div class="p-3 mb-3" style="background:var(--slate-50);border-radius:var(--radius-md);border:1px solid var(--slate-200);">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span style="font-weight:700;font-size:.85rem;">
                                                Claim from {{ optional($claim->employee)->name ?? 'Unknown' }}
                                            </span>
                                            <span style="font-size:.75rem;color:var(--slate-400);">
                                                {{ $claim->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        <p style="font-size:.83rem;margin:0;color:var(--slate-600);">
                                            {{ $claim->description ?? $claim->body ?? '—' }}
                                        </p>
                                    </div>

                                    @if($claim->status === 'resolved' && $claim->admin_response)
                                    <div class="p-3 mb-3" style="background:var(--green-100);border-radius:var(--radius-md);border:1px solid #A7F3D0;">
                                        <div style="font-size:.75rem;font-weight:700;color:#065F46;margin-bottom:4px;">
                                            <i class="bi bi-check-circle-fill me-1"></i>Resolution Response
                                        </div>
                                        <p style="font-size:.83rem;margin:0;color:#065F46;">
                                            {{ $claim->admin_response }}
                                        </p>
                                    </div>
                                    @endif

                                    @if($claim->status !== 'resolved')
                                    <form action="{{ route('gov.claims.resolve', $claim->id) }}" method="POST" id="resolveForm{{ $claim->id }}">
                                        @csrf
                                        <div class="mb-0">
                                            <label class="form-label">Your Response / Resolution</label>
                                            <textarea name="response" class="form-control" rows="4"
                                                placeholder="Describe the resolution or outcome…" required></textarea>
                                        </div>
                                    </form>
                                    @endif

                                </div>
                                <div class="modal-footer" style="border-color:var(--slate-200);">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                    @if($claim->status !== 'resolved')
                                    <button type="submit" form="resolveForm{{ $claim->id }}" class="btn btn-sm btn-success">
                                        <i class="bi bi-check2-circle me-1"></i>Mark as Resolved
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-flag d-block fs-2 mb-2 opacity-25"></i>
                            No claims found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($claims->hasPages())
    <div class="card-body border-top" style="border-color:var(--slate-200);">
        {{ $claims->links() }}
    </div>
    @endif
</div>

@endsection
