@extends('layouts.app')
@section('title', 'No Record Found')

@section('content')

<div class="row justify-content-center">
<div class="col-md-7">
    <div class="card text-center p-5">

        <div class="mb-4">
            <div style="width:80px;height:80px;background:#FEE2E2;border-radius:50%;
                        display:flex;align-items:center;justify-content:center;margin:0 auto;">
                <i class="bi bi-person-x" style="font-size:2.5rem;color:#DC2626;"></i>
            </div>
        </div>

        <h4 class="fw-bold mb-2">No Record Found</h4>
        <p class="text-muted mb-4">
            No verified employee profile was found for National ID:
            <code class="ms-1">{{ substr($nationalId, 0, 4) . str_repeat('*', strlen($nationalId) - 7) . substr($nationalId, -3) }}</code>
        </p>

        {{-- Search Reference --}}
        <div class="alert text-start mb-4"
             style="background:#F8FAFB;border-left:4px solid #6B7280;border-radius:8px;">
            <small class="text-muted">
                <strong>Search Reference:</strong> #{{ $log->id }} ·
                {{ $log->searched_at->format('d M Y, H:i') }}
            </small>
        </div>

        {{-- Reasons --}}
        <div class="card mb-4" style="background:#F8FAFB;">
            <div class="card-body text-start">
                <small class="fw-semibold text-muted text-uppercase">
                    Possible Reasons
                </small>
                <ul class="mt-2 mb-0 small text-muted">
                    <li class="mb-1">
                        The National ID has not been registered in the system
                    </li>
                    <li class="mb-1">
                        The employee has set their profile to hidden
                    </li>
                    <li class="mb-1">
                        The National ID number may have been entered incorrectly
                    </li>
                    <li>
                        The profile has not been verified by NIDA yet
                    </li>
                </ul>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('employer.verify.index') }}"
               class="btn btn-primary px-4">
                <i class="bi bi-search me-2"></i>Search Again
            </a>
            <a href="{{ route('employer.dashboard') }}"
               class="btn btn-outline-secondary px-4">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </div>

    </div>
</div>
</div>

@endsection