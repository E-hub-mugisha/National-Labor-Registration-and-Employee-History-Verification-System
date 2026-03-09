@extends('layouts.app')
@section('title', 'Manage Employees')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Registered Employees</h4>
        <small class="text-muted">All employees in the national registry</small>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#F8FAFB;font-size:.85rem;">
                <tr>
                    <th class="ps-3">Employee</th>
                    <th>National ID</th>
                    <th>District</th>
                    <th>Status</th>
                    <th>NIDA</th>
                    <th>Profile</th>
                    <th>Registered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td class="ps-3">
                        <div class="fw-medium small">
                            {{ $employee->full_name }}
                        </div>
                        <div class="text-muted" style="font-size:.75rem;">
                            {{ $employee->user->email }}
                        </div>
                    </td>
                    <td>
                        <code>{{ $employee->masked_national_id }}</code>
                    </td>
                    <td>
                        <small>{{ $employee->district ?? '—' }}</small>
                    </td>
                    <td>
                        <span class="badge
                            {{ $employee->employment_status === 'employed'
                                ? 'badge-verified'
                                : 'bg-secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $employee->employment_status)) }}
                        </span>
                    </td>
                    <td>
                        @if($employee->nida_verified)
                            <span class="badge badge-verified">
                                <i class="bi bi-patch-check-fill me-1"></i>Verified
                            </span>
                        @else
                            <span class="badge badge-pending">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($employee->profile_complete)
                            <span class="badge badge-verified">Complete</span>
                        @else
                            <span class="badge bg-secondary">Incomplete</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $employee->created_at->format('d M Y') }}
                        </small>
                    </td>
                    <td>
                        @if(!$employee->nida_verified)

                            {{-- Verify Button --}}
                            <form method="POST"
                                  action="{{ route('admin.employees.verify', $employee) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="verify">
                                <button class="btn btn-success btn-sm"
                                        title="Verify Employee"
                                        onclick="return confirm('Verify {{ $employee->full_name }}?')">
                                    <i class="bi bi-patch-check me-1"></i>Verify
                                </button>
                            </form>

                        @else

                            {{-- Unverify Button --}}
                            <form method="POST"
                                  action="{{ route('admin.employees.verify', $employee) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="unverify">
                                <button class="btn btn-outline-danger btn-sm"
                                        title="Remove Verification"
                                        onclick="return confirm('Remove verification for {{ $employee->full_name }}?')">
                                    <i class="bi bi-x-circle me-1"></i>Unverify
                                </button>
                            </form>

                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">
                        <i class="bi bi-people fs-2 d-block mb-2 opacity-25"></i>
                        No employees registered yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $employees->links() }}
    </div>
</div>

@endsection