@extends('layouts.app')
@section('title', 'Audit Log')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Audit Log</h4>
        <small class="text-muted">All system actions and events</small>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#F8FAFB;font-size:.85rem;">
                <tr>
                    <th class="ps-3">User</th>
                    <th>Action</th>
                    <th>Model</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="ps-3">
                        <div class="fw-medium small">
                            {{ $log->user?->name ?? 'System' }}
                        </div>
                        <div class="text-muted" style="font-size:.75rem;">
                            {{ $log->user?->user_type ?? '—' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge
                            @if($log->action === 'created')  bg-success
                            @elseif($log->action === 'updated') bg-primary
                            @elseif($log->action === 'deleted') bg-danger
                            @elseif($log->action === 'verified') bg-info
                            @elseif($log->action === 'searched') bg-warning
                            @else bg-secondary
                            @endif">
                            {{ $log->action_label }}
                        </span>
                    </td>
                    <td>
                        @if($log->model_type)
                            <small class="text-muted">
                                {{ class_basename($log->model_type) }}
                                @if($log->model_id)
                                    #{{ $log->model_id }}
                                @endif
                            </small>
                        @else
                            <small class="text-muted">—</small>
                        @endif
                    </td>
                    <td>
                        <small>{{ $log->description ?? '—' }}</small>
                    </td>
                    <td>
                        <code style="font-size:.75rem;">
                            {{ $log->ip_address ?? '—' }}
                        </code>
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </small>
                        <div class="text-muted" style="font-size:.72rem;">
                            {{ $log->created_at->diffForHumans() }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-journal-text fs-2 d-block mb-2 opacity-25"></i>
                        No audit logs yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $logs->links() }}
    </div>
</div>

@endsection