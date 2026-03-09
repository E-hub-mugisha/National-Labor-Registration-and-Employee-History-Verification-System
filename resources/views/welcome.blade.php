@extends('layouts.app')
@section('title', 'Welcome')

@section('content')

{{-- Hero Section --}}
<div class="py-5 text-center" style="background:linear-gradient(135deg,#1B3A6B,#2E6DB4);border-radius:16px;color:#fff;margin-bottom:2rem; margin-top:2rem;">
    <div class="py-4">
        <div class="mb-3">
            <i class="bi bi-shield-check" style="font-size:4rem;color:#4CAF50;"></i>
        </div>
        <h1 class="fw-bold mb-2">National Labor Registration &</h1>
        <h1 class="fw-bold mb-3">Employee History Verification System</h1>
        <p class="lead mb-4" style="color:rgba(255,255,255,.8);max-width:600px;margin:0 auto;">
            A secure, government-backed platform for transparent employment
            verification and labor market accountability in Rwanda.
        </p>
        @guest
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                    <i class="bi bi-person-plus me-2"></i>Register
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </a>
            </div>
        @else
            @if(Auth::user()->user_type === 'employee')
                <a href="{{ route('employee.dashboard') }}" class="btn btn-light btn-lg px-4">
                    <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                </a>
            @elseif(Auth::user()->user_type === 'employer')
                <a href="{{ route('employer.dashboard') }}" class="btn btn-light btn-lg px-4">
                    <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg px-4">
                    <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                </a>
            @endif
        @endguest
    </div>
</div>

{{-- Features --}}
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card h-100 text-center p-4">
            <div class="mb-3">
                <div style="width:60px;height:60px;background:#E8F0FB;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                    <i class="bi bi-person-vcard" style="font-size:1.8rem;color:#1B3A6B;"></i>
                </div>
            </div>
            <h6 class="fw-bold">Employee Registration</h6>
            <p class="text-muted small">
                Register using your National ID. Build a verified, portable professional identity.
            </p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 text-center p-4">
            <div class="mb-3">
                <div style="width:60px;height:60px;background:#E8F5EE;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                    <i class="bi bi-building-check" style="font-size:1.8rem;color:#1A7A4A;"></i>
                </div>
            </div>
            <h6 class="fw-bold">Employer Management</h6>
            <p class="text-muted small">
                Register your organization, report hires and exits with mandatory documentation.
            </p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 text-center p-4">
            <div class="mb-3">
                <div style="width:60px;height:60px;background:#FEF3C7;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                    <i class="bi bi-star-half" style="font-size:1.8rem;color:#D97706;"></i>
                </div>
            </div>
            <h6 class="fw-bold">Professional Feedback</h6>
            <p class="text-muted small">
                Structured conduct assessments submitted by verified employers after employment ends.
            </p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 text-center p-4">
            <div class="mb-3">
                <div style="width:60px;height:60px;background:#FEE2E2;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                    <i class="bi bi-search" style="font-size:1.8rem;color:#DC2626;"></i>
                </div>
            </div>
            <h6 class="fw-bold">Verification Portal</h6>
            <p class="text-muted small">
                Search verified employment history by National ID for informed hiring decisions.
            </p>
        </div>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-5">
    <div class="col-12">
        <div class="card p-4" style="background:linear-gradient(135deg,#1B3A6B,#2E6DB4);">
            <div class="row text-center text-white">
                <div class="col-md-3 border-end border-light border-opacity-25">
                    <div class="fs-2 fw-bold">{{ \App\Models\Employee::count() }}</div>
                    <div class="small opacity-75">Registered Employees</div>
                </div>
                <div class="col-md-3 border-end border-light border-opacity-25">
                    <div class="fs-2 fw-bold">{{ \App\Models\Employer::where('verification_status','verified')->count() }}</div>
                    <div class="small opacity-75">Verified Employers</div>
                </div>
                <div class="col-md-3 border-end border-light border-opacity-25">
                    <div class="fs-2 fw-bold">{{ \App\Models\EmploymentRecord::count() }}</div>
                    <div class="small opacity-75">Employment Records</div>
                </div>
                <div class="col-md-3">
                    <div class="fs-2 fw-bold">{{ \App\Models\VerificationRequest::count() }}</div>
                    <div class="small opacity-75">Verifications Done</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Register CTA --}}
@guest
<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-4 h-100" style="border-left:4px solid #1B3A6B;">
            <h5 class="fw-bold mb-2">
                <i class="bi bi-person-circle me-2 text-primary"></i>I am a Job Seeker
            </h5>
            <p class="text-muted small mb-3">
                Create your verified professional profile linked to your National ID.
                Control your employment history and professional feedback.
            </p>
            <a href="{{ route('register') }}" class="btn btn-primary">
                Register as Employee
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 h-100" style="border-left:4px solid #1A7A4A;">
            <h5 class="fw-bold mb-2">
                <i class="bi bi-building me-2 text-success"></i>I am an Employer
            </h5>
            <p class="text-muted small mb-3">
                Register your organization, manage your workforce records and
                access the employee verification portal.
            </p>
            <a href="{{ route('register') }}" class="btn btn-success">
                Register as Employer
            </a>
        </div>
    </div>
</div>
@endguest

@endsection