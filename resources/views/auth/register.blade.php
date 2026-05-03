@extends('layouts.app')

@section('title', 'Create Account')

@section('content')

<style>
    /* ── Role selector cards ───────────────────────────── */
    .role-card {
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 1.25rem 1rem;
        cursor: pointer;
        transition: border-color .2s, background .2s, box-shadow .2s;
        text-align: center;
        user-select: none;
    }
    .role-card:hover {
        border-color: #0d6efd;
        background: #f0f5ff;
    }
    .role-card.selected {
        border-color: #0d6efd;
        background: #e8f0fe;
        box-shadow: 0 0 0 3px rgba(13,110,253,.15);
    }
    .role-card .role-icon {
        width: 48px; height: 48px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto .75rem;
        font-size: 1.3rem;
    }
    .role-card .role-label {
        font-weight: 700; font-size: .9rem; margin-bottom: .2rem;
    }
    .role-card .role-desc {
        font-size: .75rem; color: #6c757d; line-height: 1.4;
    }

    /* ── Form panels ───────────────────────────────────── */
    .form-panel { display: none; }
    .form-panel.active { display: block; }

    /* ── Section titles inside form ────────────────────── */
    .form-section-title {
        font-size: .72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .08em; color: #0d6efd;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: .4rem; margin: 1.5rem 0 .9rem;
    }

    /* ── Step indicator ─────────────────────────────────── */
    .step-pill {
        display: inline-flex; align-items: center; gap: .4rem;
        background: #e8f0fe; color: #0d6efd;
        border-radius: 20px; padding: .25rem .75rem;
        font-size: .75rem; font-weight: 600;
    }
    .step-pill svg { width: 14px; height: 14px; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">

            {{-- ── Card ──────────────────────────────────── --}}
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">

                    {{-- Logo / Brand --}}
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-1">Create an Account</h2>
                        <p class="text-muted small mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign in</a>
                        </p>
                    </div>

                    {{-- ── Alerts ─────────────────────────── --}}
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Please fix the following:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- ── Step 1: Role Selector ─────────── --}}
                    <div id="role-selector-section">
                        <p class="fw-semibold text-center mb-3">I am registering as a…</p>

                        <div class="row g-3 mb-4">
                            {{-- Government --}}
                            <div class="col-6">
                                <div class="role-card {{ old('role') === 'government' ? 'selected' : '' }}"
                                     id="card-government"
                                     onclick="selectRole('government')">
                                    <div class="role-icon bg-info bg-opacity-10 text-info">🏛️</div>
                                    <div class="role-label">Government Official</div>
                                    <div class="role-desc">Ministry or agency representative with oversight access</div>
                                </div>
                            </div>
                            {{-- Employer --}}
                            <div class="col-6">
                                <div class="role-card {{ old('role') === 'employer' ? 'selected' : '' }}"
                                     id="card-employer"
                                     onclick="selectRole('employer')">
                                    <div class="role-icon bg-primary bg-opacity-10 text-primary">🏢</div>
                                    <div class="role-label">Employer</div>
                                    <div class="role-desc">Company or organisation managing employment records</div>
                                </div>
                            </div>
                        </div>

                        <p class="text-muted text-center small" id="role-prompt">
                            Select a role above to continue.
                        </p>
                    </div>

                    {{-- ══════════════════════════════════════
                         GOVERNMENT FORM
                    ══════════════════════════════════════ --}}
                    <div class="form-panel" id="panel-government">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <span class="step-pill">
                                <svg viewBox="0 0 20 20" fill="currentColor"><path d="M7 9a2 2 0 100-4 2 2 0 000 4zm5-2a1 1 0 11-2 0 1 1 0 012 0zM7 13a6 6 0 00-5.477 3.11A1 1 0 002.5 18h9a1 1 0 00.977-1.89A6 6 0 007 13zm5.5.5a.5.5 0 01.5-.5h4a.5.5 0 010 1h-4a.5.5 0 01-.5-.5z"/></svg>
                                Government Official
                            </span>
                            <button type="button" class="btn btn-link btn-sm text-muted p-0 ms-auto"
                                    onclick="resetRole()">← Change role</button>
                        </div>

                        <form method="POST" action="{{ route('register') }}" id="gov-form">
                            @csrf
                            <input type="hidden" name="role" value="government">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold small" for="gov_name">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="gov_name" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="Your full name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="gov_email">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" id="gov_email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="you@gov.rw" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="gov_ministry">
                                        Ministry / Agency <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="gov_ministry" name="ministry"
                                           class="form-control @error('ministry') is-invalid @enderror"
                                           value="{{ old('ministry') }}"
                                           placeholder="e.g. Ministry of Labour" required>
                                    @error('ministry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="gov_password">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" id="gov_password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Min. 8 characters" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="gov_password_confirm">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" id="gov_password_confirm"
                                           name="password_confirmation"
                                           class="form-control"
                                           placeholder="Repeat password" required>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100 fw-semibold" id="gov-submit">
                                        Create Government Account
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>{{-- /panel-government --}}


                    {{-- ══════════════════════════════════════
                         EMPLOYER FORM
                    ══════════════════════════════════════ --}}
                    <div class="form-panel" id="panel-employer">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="step-pill">
                                <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v4H7V5zm8 8v2h1v1H4v-1h1v-2a1 1 0 011-1h8a1 1 0 011 1z" clip-rule="evenodd"/></svg>
                                Employer Registration
                            </span>
                            <button type="button" class="btn btn-link btn-sm text-muted p-0 ms-auto"
                                    onclick="resetRole()">← Change role</button>
                        </div>

                        <div class="alert alert-info d-flex align-items-start gap-2 py-2" role="alert">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="flex-shrink-0 mt-1">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="small">
                                We'll <strong>auto-generate your login credentials</strong> and send them to the
                                email address you provide. Your account will be reviewed before activation.
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register') }}" id="employer-form"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="role" value="employer">

                            {{-- Company Info --}}
                            <div class="form-section-title">Company Information</div>
                            <div class="row g-3">

                                <div class="col-12">
                                    <label class="form-label fw-semibold small" for="emp_name">
                                        Company / Organisation Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="emp_name" name="emp_name"
                                           class="form-control @error('emp_name') is-invalid @enderror"
                                           value="{{ old('emp_name') }}"
                                           placeholder="e.g. Kigali Tech Ltd." required>
                                    @error('emp_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="tin_number">
                                        TIN Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="tin_number" name="tin_number"
                                           class="form-control @error('tin_number') is-invalid @enderror"
                                           value="{{ old('tin_number') }}"
                                           placeholder="9-digit TIN" required>
                                    @error('tin_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="registration_number">
                                        Registration Number
                                    </label>
                                    <input type="text" id="registration_number" name="registration_number"
                                           class="form-control @error('registration_number') is-invalid @enderror"
                                           value="{{ old('registration_number') }}"
                                           placeholder="RDB / RURA reg. no.">
                                    @error('registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="sector">
                                        Sector <span class="text-danger">*</span>
                                    </label>
                                    <select id="sector" name="sector"
                                            class="form-select @error('sector') is-invalid @enderror" required>
                                        <option value="">Select sector…</option>
                                        <option value="public_administration" {{ old('sector') === 'public_administration' ? 'selected' : '' }}>Public Administration</option>
                                        <option value="banking_finance"       {{ old('sector') === 'banking_finance'       ? 'selected' : '' }}>Banking &amp; Finance</option>
                                        <option value="hospitality_tourism"   {{ old('sector') === 'hospitality_tourism'   ? 'selected' : '' }}>Hospitality &amp; Tourism</option>
                                        <option value="bpo_call_center"       {{ old('sector') === 'bpo_call_center'       ? 'selected' : '' }}>BPO / Call Center</option>
                                        <option value="healthcare"            {{ old('sector') === 'healthcare'            ? 'selected' : '' }}>Healthcare</option>
                                        <option value="education"             {{ old('sector') === 'education'             ? 'selected' : '' }}>Education</option>
                                        <option value="manufacturing"         {{ old('sector') === 'manufacturing'         ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="construction"          {{ old('sector') === 'construction'          ? 'selected' : '' }}>Construction</option>
                                        <option value="agriculture"           {{ old('sector') === 'agriculture'           ? 'selected' : '' }}>Agriculture</option>
                                        <option value="ngo"                   {{ old('sector') === 'ngo'                   ? 'selected' : '' }}>NGO / Non-Profit</option>
                                        <option value="technology"            {{ old('sector') === 'technology'            ? 'selected' : '' }}>Technology</option>
                                        <option value="retail"                {{ old('sector') === 'retail'                ? 'selected' : '' }}>Retail</option>
                                        <option value="other"                 {{ old('sector') === 'other'                 ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('sector')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="emp_logo">Company Logo</label>
                                    <input type="file" id="emp_logo" name="logo"
                                           class="form-control @error('logo') is-invalid @enderror"
                                           accept="image/*">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">PNG/JPG, max 2 MB</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small" for="description">
                                        Company Description
                                    </label>
                                    <textarea id="description" name="description" rows="2"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Brief description of what your company does…">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>{{-- /row --}}

                            {{-- Contact Details --}}
                            <div class="form-section-title">Contact &amp; Location</div>
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="emp_email">
                                        Official Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" id="emp_email" name="emp_email"
                                           class="form-control @error('emp_email') is-invalid @enderror"
                                           value="{{ old('emp_email') }}"
                                           placeholder="info@company.rw" required>
                                    @error('emp_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Login credentials will be sent here.</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="phone">
                                        Phone <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="phone" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="+250 7XX XXX XXX" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="province">
                                        Province <span class="text-danger">*</span>
                                    </label>
                                    <select id="province" name="province"
                                            class="form-select @error('province') is-invalid @enderror" required>
                                        <option value="">Select province…</option>
                                        <option value="Kigali"   {{ old('province') === 'Kigali'   ? 'selected' : '' }}>Kigali City</option>
                                        <option value="Northern" {{ old('province') === 'Northern' ? 'selected' : '' }}>Northern Province</option>
                                        <option value="Southern" {{ old('province') === 'Southern' ? 'selected' : '' }}>Southern Province</option>
                                        <option value="Eastern"  {{ old('province') === 'Eastern'  ? 'selected' : '' }}>Eastern Province</option>
                                        <option value="Western"  {{ old('province') === 'Western'  ? 'selected' : '' }}>Western Province</option>
                                    </select>
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="district">
                                        District <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="district" name="district"
                                           class="form-control @error('district') is-invalid @enderror"
                                           value="{{ old('district') }}"
                                           placeholder="e.g. Gasabo" required>
                                    @error('district')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="address">Address</label>
                                    <input type="text" id="address" name="address"
                                           class="form-control @error('address') is-invalid @enderror"
                                           value="{{ old('address') }}"
                                           placeholder="Street / KG / KN / KK…">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small" for="website">Website</label>
                                    <input type="url" id="website" name="website"
                                           class="form-control @error('website') is-invalid @enderror"
                                           value="{{ old('website') }}"
                                           placeholder="https://company.rw">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>{{-- /row --}}

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-100 fw-semibold" id="emp-submit">
                                    Submit Employer Registration
                                </button>
                                <p class="text-muted text-center small mt-2 mb-0">
                                    Your application will be reviewed. Login credentials will be emailed upon submission.
                                </p>
                            </div>

                        </form>
                    </div>{{-- /panel-employer --}}

                </div>{{-- /card-body --}}
            </div>{{-- /card --}}

        </div>
    </div>
</div>

<script>
    const panels    = ['government', 'employer'];
    const oldRole   = '{{ old("role") }}';

    function selectRole(role) {
        // Highlight selected card
        panels.forEach(r => {
            document.getElementById('card-' + r)?.classList.remove('selected');
            document.getElementById('panel-' + r)?.classList.remove('active');
        });

        document.getElementById('card-' + role)?.classList.add('selected');
        document.getElementById('panel-' + role)?.classList.add('active');
        document.getElementById('role-prompt').style.display = 'none';
    }

    function resetRole() {
        panels.forEach(r => {
            document.getElementById('card-' + r)?.classList.remove('selected');
            document.getElementById('panel-' + r)?.classList.remove('active');
        });
        document.getElementById('role-prompt').style.display = 'block';
    }

    // Restore role on validation-error redirect
    if (oldRole && (oldRole === 'government' || oldRole === 'employer')) {
        selectRole(oldRole);
    }

    // Prevent double-submit on government form
    document.getElementById('gov-form').addEventListener('submit', function () {
        const btn = document.getElementById('gov-submit');
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span>Creating account…`;
    });

    // Prevent double-submit on employer form
    document.getElementById('employer-form').addEventListener('submit', function () {
        const btn = document.getElementById('emp-submit');
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span>Submitting…`;
    });
</script>

@endsection