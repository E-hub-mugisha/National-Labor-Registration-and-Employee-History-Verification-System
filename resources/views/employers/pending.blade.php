@extends('layouts.app')
@section('title', 'Pending Verification')

@section('content')

<div class="row justify-content-center">
<div class="col-md-7">
    <div class="card text-center p-5">

        <div class="mb-4">
            <div style="width:80px;height:80px;background:#FEF3C7;border-radius:50%;
                        display:flex;align-items:center;justify-content:center;margin:0 auto;">
                <i class="bi bi-hourglass-split" style="font-size:2.5rem;color:#D97706;"></i>
            </div>
        </div>

        <h4 class="fw-bold mb-2">Registration Under Review</h4>
        <p class="text-muted mb-4">
            Your employer registration has been submitted successfully.
            A government administrator will verify your RDB registration
            details before activating your account.
        </p>

        <div class="card mb-4" style="background:#F8FAFB;">
            <div class="card-body">
                <div class="row text-start g-3">
                    <div class="col-12">
                        <small class="text-muted fw-semibold text-uppercase">What happens next?</small>
                    </div>
                    <div class="col-12 d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;background:#E8F0FB;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span class="fw-bold text-primary small">1</span>
                        </div>
                        <div>
                            <div class="fw-semibold small">RDB Verification</div>
                            <div class="text-muted small">
                                Your RDB number is cross-checked with the Rwanda Development Board database.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;background:#E8F0FB;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span class="fw-bold text-primary small">2</span>
                        </div>
                        <div>
                            <div class="fw-semibold small">Admin Review</div>
                            <div class="text-muted small">
                                A government administrator reviews your registration details.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;background:#E8F0FB;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span class="fw-bold text-primary small">3</span>
                        </div>
                        <div>
                            <div class="fw-semibold small">Account Activation</div>
                            <div class="text-muted small">
                                Once approved you can report hires, submit feedback
                                and access the verification portal.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info text-start mb-4">
            <i class="bi bi-envelope me-2"></i>
            You will receive an email notification once your account
            has been reviewed. This usually takes <strong>1–2 business days</strong>.
        </div>

        <a href="{{ route('home') }}" class="btn btn-outline-primary px-4">
            <i class="bi bi-house me-2"></i>Back to Home
        </a>

    </div>
</div>
</div>

@endsection