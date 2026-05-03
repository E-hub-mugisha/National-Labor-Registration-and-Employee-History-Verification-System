@extends('layouts.app')

@section('title', 'Application Pending – ' . $employer->name)

@section('content')

<style>
    /* ── Timeline ───────────────────────────────────────── */
    .timeline        { position: relative; padding-left: 2.25rem; }
    .timeline::before {
        content: ''; position: absolute; left: .65rem; top: 0; bottom: 0;
        width: 2px; background: #dee2e6; border-radius: 2px;
    }
    .tl-item         { position: relative; margin-bottom: 1.5rem; }
    .tl-item:last-child { margin-bottom: 0; }
    .tl-dot {
        position: absolute; left: -2.25rem;
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem; font-weight: 700; flex-shrink: 0;
        border: 2px solid #fff; box-shadow: 0 0 0 2px #dee2e6;
    }
    .tl-dot.done     { background: #198754; color: #fff; box-shadow: 0 0 0 2px #198754; }
    .tl-dot.active   { background: #ffc107; color: #fff; box-shadow: 0 0 0 2px #ffc107; animation: pulse 2s infinite; }
    .tl-dot.waiting  { background: #e9ecef; color: #adb5bd; }
    .tl-title        { font-weight: 600; font-size: .9rem; margin-bottom: .15rem; line-height: 1.3; }
    .tl-sub          { font-size: .78rem; color: #6c757d; line-height: 1.4; }

    @@keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 2px #ffc107; }
        50%       { box-shadow: 0 0 0 5px rgba(255,193,7,.3); }
    }

    /* ── Stat badge ─────────────────────────────────────── */
    .info-row  { display: flex; justify-content: space-between; align-items: flex-start;
                 padding: .55rem 0; border-bottom: 1px solid #f0f0f0; font-size: .85rem; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #6c757d; font-weight: 500; flex-shrink: 0; margin-right: 1rem; }
    .info-value { font-weight: 600; text-align: right; word-break: break-all; }

    /* ── Countdown ring ─────────────────────────────────── */
    .status-ring {
        width: 100px; height: 100px; border-radius: 50%;
        border: 4px solid #fff3cd;
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; background: #fff8e1; margin: 0 auto 1rem;
    }
    .status-ring svg { width: 36px; height: 36px; color: #ffc107; }

    /* ── What next card ─────────────────────────────────── */
    .next-card {
        border-left: 3px solid #0d6efd;
        border-radius: 8px;
        background: #f0f5ff;
        padding: .85rem 1rem;
        font-size: .83rem;
        line-height: 1.55;
    }
    .next-card + .next-card { margin-top: .6rem; }
    .next-card .nc-num {
        width: 22px; height: 22px; border-radius: 50%;
        background: #0d6efd; color: #fff; font-weight: 700;
        font-size: .7rem; display: inline-flex;
        align-items: center; justify-content: center;
        flex-shrink: 0; margin-right: .5rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">

            {{-- ── Flash Message ──────────────────────────── --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="flex-shrink-0">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- ── Hero Status Banner ─────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4 text-center"
                 style="background: linear-gradient(135deg, #fff8e1 0%, #fff3cd 100%); border-top: 4px solid #ffc107 !important;">
                <div class="card-body py-4">
                    <div class="status-ring">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="fw-bold mb-1" style="color:#856404">Application Under Review</h2>
                    <p class="text-warning-emphasis mb-3" style="font-size:.9rem">
                        Your employer account is pending verification.
                        We'll notify you by email once it's approved.
                    </p>
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                        ⏳&nbsp; Pending Verification
                    </span>
                </div>
            </div>

            <div class="row g-4">

                {{-- ── Left Column ───────────────────────── --}}
                <div class="col-md-7">

                    {{-- Application Summary --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom fw-bold d-flex align-items-center gap-2 py-3">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="text-primary">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v4H7V5zm8 8v2h1v1H4v-1h1v-2a1 1 0 011-1h8a1 1 0 011 1z" clip-rule="evenodd"/>
                            </svg>
                            Application Summary
                        </div>
                        <div class="card-body">

                            {{-- Logo --}}
                            @if($employer->logo)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $employer->logo) }}"
                                     alt="{{ $employer->name }}"
                                     class="rounded border"
                                     style="max-height:70px; max-width:160px; object-fit:contain;">
                            </div>
                            @endif

                            <div class="info-row">
                                <span class="info-label">Company Name</span>
                                <span class="info-value">{{ $employer->name }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">TIN Number</span>
                                <span class="info-value">{{ $employer->tin_number }}</span>
                            </div>
                            @if($employer->registration_number)
                            <div class="info-row">
                                <span class="info-label">Reg. Number</span>
                                <span class="info-value">{{ $employer->registration_number }}</span>
                            </div>
                            @endif
                            <div class="info-row">
                                <span class="info-label">Sector</span>
                                <span class="info-value">{{ $employer->sector_label }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Province</span>
                                <span class="info-value">{{ $employer->province }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">District</span>
                                <span class="info-value">{{ $employer->district }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone</span>
                                <span class="info-value">{{ $employer->phone }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $employer->email }}</span>
                            </div>
                            @if($employer->website)
                            <div class="info-row">
                                <span class="info-label">Website</span>
                                <span class="info-value">
                                    <a href="{{ $employer->website }}" target="_blank" rel="noopener" class="text-primary">
                                        {{ $employer->website }}
                                    </a>
                                </span>
                            </div>
                            @endif
                            <div class="info-row">
                                <span class="info-label">Submitted</span>
                                <span class="info-value">{{ $employer->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status</span>
                                <span class="info-value">
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Rejection notice (if any) --}}
                    @if($employer->status === 'rejected' && $employer->rejection_reason)
                    <div class="alert alert-danger d-flex align-items-start gap-2" role="alert">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20" class="flex-shrink-0 mt-1">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <strong class="d-block">Application Rejected</strong>
                            {{ $employer->rejection_reason }}
                        </div>
                    </div>
                    @endif

                </div>{{-- /col --}}

                {{-- ── Right Column ───────────────────────── --}}
                <div class="col-md-5">

                    {{-- Review Timeline --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom fw-bold d-flex align-items-center gap-2 py-3">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="text-primary">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            Review Progress
                        </div>
                        <div class="card-body">
                            <div class="timeline">

                                <div class="tl-item">
                                    <div class="tl-dot done">✓</div>
                                    <div class="tl-title">Application Submitted</div>
                                    <div class="tl-sub">{{ $employer->created_at->format('d M Y, H:i') }}</div>
                                </div>

                                <div class="tl-item">
                                    <div class="tl-dot done">✓</div>
                                    <div class="tl-title">Credentials Sent</div>
                                    <div class="tl-sub">Login details emailed to {{ $employer->email }}</div>
                                </div>

                                <div class="tl-item">
                                    <div class="tl-dot {{ $employer->status === 'pending' ? 'active' : 'done' }}">
                                        {{ $employer->status === 'pending' ? '…' : '✓' }}
                                    </div>
                                    <div class="tl-title">Under Review</div>
                                    <div class="tl-sub">
                                        @if($employer->status === 'pending')
                                            Our team is verifying your information
                                        @else
                                            Review completed
                                        @endif
                                    </div>
                                </div>

                                <div class="tl-item">
                                    <div class="tl-dot {{ $employer->status === 'verified' ? 'done' : 'waiting' }}">
                                        {{ $employer->status === 'verified' ? '✓' : '4' }}
                                    </div>
                                    <div class="tl-title">Account Activated</div>
                                    <div class="tl-sub">
                                        @if($employer->status === 'verified')
                                            Verified {{ $employer->verified_at?->format('d M Y') }}
                                        @else
                                            Awaiting admin approval
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- What happens next --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom fw-bold d-flex align-items-center gap-2 py-3">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="text-primary">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/>
                            </svg>
                            What Happens Next
                        </div>
                        <div class="card-body pb-2">
                            <div class="next-card d-flex align-items-start">
                                <span class="nc-num">1</span>
                                Our team will verify your TIN number and registration details with RRA and RDB.
                            </div>
                            <div class="next-card d-flex align-items-start">
                                <span class="nc-num">2</span>
                                You'll receive an email notification once your account is approved or if more information is needed.
                            </div>
                            <div class="next-card d-flex align-items-start mb-2">
                                <span class="nc-num">3</span>
                                Upon approval, your account will be activated and you can begin adding employment records.
                            </div>
                        </div>
                    </div>

                    {{-- Contact / Support --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-3 text-center">
                            <p class="small text-muted mb-2">Have questions about your application?</p>
                            <a href="mailto:{{ config('mail.from.address') }}"
                               class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-2">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z"/>
                                    <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z"/>
                                </svg>
                                Contact Support
                            </a>
                        </div>
                    </div>

                </div>{{-- /col --}}

            </div>{{-- /row --}}

            {{-- ── Logout link ─────────────────────────────── --}}
            <div class="text-center mt-4">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted small text-decoration-none">
                        Sign out of this account
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection