<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — EmpRecord Rwanda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">


<style>
    /* ═══════════════════════════════════════════
       DESIGN TOKENS (mirrored from welcome page)
    ═══════════════════════════════════════════ */
    :root {
        --navy:        #0b1f3a;
        --navy-mid:    #132d52;
        --navy-light:  #1a3d6e;
        --gold:        #c4922a;
        --gold-light:  #e8b84b;
        --gold-pale:   #fdf3e0;
        --slate:       #4a5f7a;
        --cream:       #fafaf7;
        --border-soft: rgba(196,146,42,.2);
        --font-display:'Cormorant Garamond', Georgia, serif;
        --font-body:   'DM Sans', system-ui, sans-serif;
    }

    /* ── Page shell ──────────────────────────────────── */
    .reg-page {
        font-family: var(--font-body);
        min-height: 100vh;
        background: linear-gradient(155deg, var(--navy) 0%, var(--navy-mid) 55%, var(--navy-light) 100%);
        padding: 2.5rem 1rem;
        position: relative;
        overflow-x: hidden;
    }

    /* Rwanda flag bar */
    .reg-page::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg,
            #20603d 0%, #20603d 33%,
            #e5be01 33%, #e5be01 66%,
            #169cda 66%, #169cda 100%);
        z-index: 100;
    }

    /* Gold grid overlay */
    .reg-page::after {
        content: '';
        position: fixed; inset: 0;
        background-image:
            linear-gradient(rgba(196,146,42,.07) 1px, transparent 1px),
            linear-gradient(90deg, rgba(196,146,42,.07) 1px, transparent 1px);
        background-size: 44px 44px;
        pointer-events: none; z-index: 0;
    }

    .bg-glow {
        position: fixed;
        top: -15%; right: -10%;
        width: 520px; height: 520px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(196,146,42,.13) 0%, transparent 70%);
        pointer-events: none; z-index: 0;
    }

    /* ── Card ─────────────────────────────────────────── */
    .reg-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(196,146,42,.2);
        box-shadow: 0 32px 80px rgba(0,0,0,.35), 0 0 0 1px rgba(196,146,42,.08);
        overflow: hidden;
        position: relative; z-index: 1;
        max-width: 760px;
        margin: 0 auto;
    }

    /* ── Card header band ─────────────────────────────── */
    .card-header-band {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 60%, var(--navy-light) 100%);
        padding: 1.85rem 2rem 1.6rem;
        position: relative; overflow: hidden;
    }
    .card-header-band::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(196,146,42,.09) 1px, transparent 1px),
            linear-gradient(90deg, rgba(196,146,42,.09) 1px, transparent 1px);
        background-size: 32px 32px;
    }

    .logo-row {
        display: flex; align-items: center; gap: .7rem;
        margin-bottom: 1.25rem;
        position: relative; z-index: 1;
    }
    .logo-mark {
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--gold);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display); font-weight: 700;
        font-size: 1.05rem; color: var(--navy); flex-shrink: 0;
    }
    .logo-text {
        font-family: var(--font-display); font-size: 1.1rem;
        font-weight: 600; color: #fff; line-height: 1.1;
    }
    .logo-text small {
        display: block; font-size: .6rem; font-weight: 400;
        letter-spacing: .12em; color: var(--gold-light);
        text-transform: uppercase; font-family: var(--font-body);
    }
    .card-headline {
        font-family: var(--font-display);
        font-size: 1.7rem; font-weight: 700;
        color: #fff; line-height: 1.2;
        margin-bottom: .3rem; position: relative; z-index: 1;
    }
    .card-headline em { color: var(--gold-light); font-style: italic; }
    .card-subline {
        font-size: .77rem; color: rgba(255,255,255,.48);
        font-weight: 300; letter-spacing: .02em;
        position: relative; z-index: 1; margin: 0;
    }
    .card-subline a { color: var(--gold-light); text-decoration: none; font-weight: 500; }
    .card-subline a:hover { text-decoration: underline; }

    /* ── Card body ────────────────────────────────────── */
    .card-body-section { padding: 2rem 2rem 1.5rem; }

    /* ── Role selector cards ──────────────────────────── */
    .role-selector-label {
        font-size: .72rem; font-weight: 500; color: var(--slate);
        letter-spacing: .05em; text-transform: uppercase;
        text-align: center; margin-bottom: .85rem; display: block;
    }

    .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; margin-bottom: 1.25rem; }

    .role-card {
        border: 1.5px solid #dde3ec;
        border-radius: 10px; padding: 1.25rem 1rem;
        cursor: pointer; text-align: center;
        user-select: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
        background: var(--cream);
    }
    .role-card:hover {
        border-color: var(--gold);
        background: var(--gold-pale);
    }
    .role-card.selected {
        border-color: var(--gold);
        background: var(--gold-pale);
        box-shadow: 0 0 0 3px rgba(196,146,42,.15);
    }
    .role-icon-wrap {
        width: 48px; height: 48px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto .7rem; font-size: 1.3rem;
    }
    .role-icon-wrap.gov  { background: rgba(26,61,110,.1); }
    .role-icon-wrap.emp  { background: rgba(196,146,42,.12); }
    .role-card-title  { font-weight: 600; font-size: .88rem; color: var(--navy); margin-bottom: .2rem; }
    .role-card-desc   { font-size: .74rem; color: var(--slate); line-height: 1.45; }

    .role-hint {
        text-align: center; font-size: .8rem; color: #a0aec0;
        margin-bottom: 0; padding-bottom: .5rem;
    }

    /* ── Form panels ──────────────────────────────────── */
    .form-panel { display: none; }
    .form-panel.active { display: block; }

    /* ── Panel pill header ────────────────────────────── */
    .panel-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    .role-pill {
        display: inline-flex; align-items: center; gap: .4rem;
        background: rgba(196,146,42,.12);
        border: 1px solid rgba(196,146,42,.3);
        color: #854f0b;
        border-radius: 20px; padding: .25rem .85rem;
        font-size: .74rem; font-weight: 500;
    }
    .change-role-btn {
        background: none; border: none; cursor: pointer;
        font-size: .78rem; color: var(--slate);
        font-family: var(--font-body);
        padding: 0; transition: color .2s;
    }
    .change-role-btn:hover { color: var(--gold); }

    /* ── Info alert ───────────────────────────────────── */
    .info-banner {
        background: rgba(196,146,42,.07);
        border: 1px solid rgba(196,146,42,.25);
        border-radius: 8px; padding: .7rem .9rem;
        display: flex; align-items: flex-start; gap: .6rem;
        margin-bottom: 1.25rem;
    }
    .info-banner i { color: var(--gold); font-size: .95rem; margin-top: .05rem; flex-shrink: 0; }
    .info-banner p { font-size: .8rem; color: #6b4c10; margin: 0; line-height: 1.5; }

    /* ── Error alert ──────────────────────────────────── */
    .error-banner {
        background: rgba(220,53,69,.07);
        border: 1px solid rgba(220,53,69,.25);
        border-radius: 8px; padding: .7rem .9rem;
        font-size: .82rem; color: #842029;
        margin-bottom: 1.25rem;
    }
    .error-banner ul { margin: .4rem 0 0; padding-left: 1.1rem; }

    /* ── Section divider ──────────────────────────────── */
    .form-section-title {
        font-size: .68rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .1em;
        color: var(--gold);
        border-bottom: 1px solid rgba(196,146,42,.2);
        padding-bottom: .4rem; margin: 1.6rem 0 .9rem;
    }

    /* ── Field labels ─────────────────────────────────── */
    .field-label {
        display: block; font-size: .72rem; font-weight: 500;
        color: var(--slate); letter-spacing: .04em;
        text-transform: uppercase; margin-bottom: .4rem;
    }
    .field-label .req { color: #dc3545; margin-left: 2px; }

    /* ── Input group (icon + input) ───────────────────── */
    .input-group-styled {
        display: flex; align-items: stretch;
        border: 1.5px solid #dde3ec; border-radius: 8px;
        overflow: hidden;
        transition: border-color .2s, box-shadow .2s;
    }
    .input-group-styled:focus-within {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(196,146,42,.12);
    }
    .input-group-styled.is-invalid { border-color: #dc3545; }
    .input-group-styled .ig-icon {
        width: 40px; background: #f6f4f0;
        border-right: 1.5px solid #dde3ec;
        display: flex; align-items: center; justify-content: center;
        color: #8a9ab5; font-size: .9rem; flex-shrink: 0;
    }
    .input-group-styled input,
    .input-group-styled select,
    .input-group-styled textarea {
        flex: 1; border: none; outline: none;
        padding: .62rem .9rem;
        font-size: .87rem; font-family: var(--font-body);
        color: var(--navy); background: #fff; min-width: 0;
    }
    .input-group-styled select { cursor: pointer; }
    .input-group-styled input::placeholder,
    .input-group-styled textarea::placeholder { color: #b0bac8; }
    .input-group-styled textarea { resize: vertical; }

    /* Plain inputs (no icon) */
    .input-plain {
        width: 100%; border: 1.5px solid #dde3ec; border-radius: 8px;
        padding: .62rem .9rem; font-size: .87rem;
        font-family: var(--font-body); color: var(--navy);
        background: #fff; outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .input-plain:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(196,146,42,.12);
    }
    .input-plain.is-invalid { border-color: #dc3545; }

    /* Password toggle */
    .pw-toggle {
        background: none; border: none; cursor: pointer;
        padding: 0 .75rem; color: #8a9ab5;
        display: flex; align-items: center; font-size: .9rem;
        transition: color .2s;
    }
    .pw-toggle:hover { color: var(--gold); }

    /* ── Invalid feedback ─────────────────────────────── */
    .invalid-feedback { font-size: .75rem; margin-top: .3rem; color: #dc3545; }

    /* ── File input ───────────────────────────────────── */
    .file-hint { font-size: .73rem; color: #a0aec0; margin-top: .3rem; }

    /* ── Submit button ────────────────────────────────── */
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
        border: none; border-radius: 8px;
        padding: .75rem 1rem; color: #fff;
        font-family: var(--font-body); font-size: .9rem; font-weight: 500;
        cursor: pointer; letter-spacing: .02em;
        display: flex; align-items: center; justify-content: center; gap: .5rem;
        transition: opacity .2s, transform .15s, box-shadow .2s;
    }
    .btn-submit:hover {
        opacity: .92; transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(11,31,58,.35);
    }
    .btn-submit:active { transform: translateY(0); }
    .btn-icon-wrap {
        width: 22px; height: 22px;
        background: rgba(196,146,42,.22); border-radius: 5px;
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; color: var(--gold-light); flex-shrink: 0;
    }
    .submit-note { text-align: center; font-size: .76rem; color: #a0aec0; margin-top: .6rem; }

    /* ── Trust bar ────────────────────────────────────── */
    .trust-bar {
        background: var(--gold-pale);
        border-top: 1px solid rgba(196,146,42,.2);
        padding: .65rem 2rem;
        display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
    }
    .trust-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
    .trust-pill {
        background: rgba(196,146,42,.12); border: 1px solid rgba(196,146,42,.3);
        color: #854f0b; font-size: .65rem; font-weight: 500;
        padding: .15rem .55rem; border-radius: 20px; white-space: nowrap;
    }
    .trust-text { font-size: .7rem; color: #7a6040; }

    /* ── Responsive ───────────────────────────────────── */
    @media (max-width: 576px) {
        .card-body-section { padding: 1.5rem 1.25rem; }
        .card-header-band  { padding: 1.5rem 1.25rem 1.25rem; }
        .trust-bar         { padding: .65rem 1.25rem; }
    }
</style>
</head>

<body>
<div class="reg-page">
    <div class="bg-glow"></div>

    <div class="reg-card">

        {{-- ── Header band ────────────────────────────── --}}
        <div class="card-header-band">
            <div class="logo-row">
                <div class="logo-mark">ER</div>
                <div class="logo-text">EmpRecord <small>Rwanda</small></div>
            </div>
            <h1 class="card-headline">Create an <em>Account</em></h1>
            <p class="card-subline">
                Already have an account?
                <a href="{{ route('login') }}">Sign in here</a>
            </p>
        </div>

        {{-- ── Form body ───────────────────────────────── --}}
        <div class="card-body-section">

            {{-- Global error bag --}}
            @if ($errors->any())
                <div class="error-banner">
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="info-banner">
                    <i class="bi bi-check-circle-fill" style="color:#198754"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- ── Role selector ──────────────────────── --}}
            <div id="role-selector-section">
                <span class="role-selector-label">I am registering as a…</span>

                <div class="role-grid">

                    {{-- Government --}}
                    <div class="role-card {{ old('role') === 'government' ? 'selected' : '' }}"
                         id="card-government"
                         onclick="selectRole('government')">
                        <div class="role-icon-wrap gov">🏛️</div>
                        <div class="role-card-title">Government Official</div>
                        <div class="role-card-desc">Ministry or agency representative with oversight access</div>
                    </div>

                    {{-- Employer --}}
                    <div class="role-card {{ old('role') === 'employer' ? 'selected' : '' }}"
                         id="card-employer"
                         onclick="selectRole('employer')">
                        <div class="role-icon-wrap emp">🏢</div>
                        <div class="role-card-title">Employer</div>
                        <div class="role-card-desc">Company or organisation managing employment records</div>
                    </div>

                </div>

                <p class="role-hint" id="role-prompt">Select a role above to continue.</p>
            </div>


            {{-- ════════════════════════════════════════
                 GOVERNMENT FORM
            ════════════════════════════════════════ --}}
            <div class="form-panel" id="panel-government">

                <div class="panel-head">
                    <span class="role-pill">🏛️ &nbsp;Government Official</span>
                    <button type="button" class="change-role-btn" onclick="resetRole()">
                        ← Change role
                    </button>
                </div>

                <form method="POST" action="{{ route('register') }}" id="gov-form">
                    @csrf
                    <input type="hidden" name="role" value="government">

                    <div class="row g-3">

                        {{-- Full name --}}
                        <div class="col-12">
                            <label class="field-label" for="gov_name">Full Name <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('name') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-person"></i></span>
                                <input type="text" id="gov_name" name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Your full name" required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="field-label" for="gov_email">Email Address <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('email') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="gov_email" name="email"
                                       value="{{ old('email') }}"
                                       placeholder="you@gov.rw" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Ministry --}}
                        <div class="col-md-6">
                            <label class="field-label" for="gov_ministry">Ministry / Agency <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('ministry') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-building"></i></span>
                                <input type="text" id="gov_ministry" name="ministry"
                                       value="{{ old('ministry') }}"
                                       placeholder="e.g. Ministry of Labour" required>
                            </div>
                            @error('ministry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6">
                            <label class="field-label" for="gov_password">Password <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('password') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-lock"></i></span>
                                <input type="password" id="gov_password" name="password"
                                       placeholder="Min. 8 characters" required>
                                <button type="button" class="pw-toggle"
                                        onclick="togglePw('gov_password', 'gov_pw_icon')"
                                        aria-label="Toggle password">
                                    <i class="bi bi-eye" id="gov_pw_icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm password --}}
                        <div class="col-md-6">
                            <label class="field-label" for="gov_password_confirm">Confirm Password <span class="req">*</span></label>
                            <div class="input-group-styled">
                                <span class="ig-icon"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" id="gov_password_confirm"
                                       name="password_confirmation"
                                       placeholder="Repeat password" required>
                                <button type="button" class="pw-toggle"
                                        onclick="togglePw('gov_password_confirm', 'gov_pw2_icon')"
                                        aria-label="Toggle confirm password">
                                    <i class="bi bi-eye" id="gov_pw2_icon"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn-submit" id="gov-submit">
                                <span class="btn-icon-wrap"><i class="bi bi-arrow-right"></i></span>
                                Create Government Account
                            </button>
                        </div>

                    </div>
                </form>

            </div>{{-- /panel-government --}}


            {{-- ════════════════════════════════════════
                 EMPLOYER FORM
            ════════════════════════════════════════ --}}
            <div class="form-panel" id="panel-employer">

                <div class="panel-head">
                    <span class="role-pill">🏢 &nbsp;Employer Registration</span>
                    <button type="button" class="change-role-btn" onclick="resetRole()">
                        ← Change role
                    </button>
                </div>

                <div class="info-banner">
                    <i class="bi bi-info-circle-fill"></i>
                    <p>
                        We'll <strong>auto-generate your login credentials</strong> and send them to
                        the email address you provide. Your account will be reviewed before activation.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" id="employer-form"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="role" value="employer">

                    {{-- ── Company Information ── --}}
                    <div class="form-section-title">Company Information</div>

                    <div class="row g-3">

                        {{-- Company name --}}
                        <div class="col-12">
                            <label class="field-label" for="emp_name">
                                Company / Organisation Name <span class="req">*</span>
                            </label>
                            <div class="input-group-styled {{ $errors->has('emp_name') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-building"></i></span>
                                <input type="text" id="emp_name" name="emp_name"
                                       value="{{ old('emp_name') }}"
                                       placeholder="e.g. Kigali Tech Ltd." required>
                            </div>
                            @error('emp_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TIN --}}
                        <div class="col-md-6">
                            <label class="field-label" for="tin_number">TIN Number <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('tin_number') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-hash"></i></span>
                                <input type="text" id="tin_number" name="tin_number"
                                       value="{{ old('tin_number') }}"
                                       placeholder="9-digit TIN" required>
                            </div>
                            @error('tin_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Reg number --}}
                        <div class="col-md-6">
                            <label class="field-label" for="registration_number">Registration Number</label>
                            <div class="input-group-styled {{ $errors->has('registration_number') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-file-earmark-text"></i></span>
                                <input type="text" id="registration_number" name="registration_number"
                                       value="{{ old('registration_number') }}"
                                       placeholder="RDB / RURA reg. no.">
                            </div>
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sector --}}
                        <div class="col-md-6">
                            <label class="field-label" for="sector">Sector <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('sector') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-grid"></i></span>
                                <select id="sector" name="sector" required>
                                    <option value="">Select sector…</option>
                                    @foreach ([
                                        'public_administration' => 'Public Administration',
                                        'banking_finance'       => 'Banking & Finance',
                                        'hospitality_tourism'   => 'Hospitality & Tourism',
                                        'bpo_call_center'       => 'BPO / Call Center',
                                        'healthcare'            => 'Healthcare',
                                        'education'             => 'Education',
                                        'manufacturing'         => 'Manufacturing',
                                        'construction'          => 'Construction',
                                        'agriculture'           => 'Agriculture',
                                        'ngo'                   => 'NGO / Non-Profit',
                                        'technology'            => 'Technology',
                                        'retail'                => 'Retail',
                                        'other'                 => 'Other',
                                    ] as $val => $label)
                                        <option value="{{ $val }}" {{ old('sector') === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('sector')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Logo --}}
                        <div class="col-md-6">
                            <label class="field-label" for="emp_logo">Company Logo</label>
                            <input type="file" id="emp_logo" name="logo"
                                   class="input-plain {{ $errors->has('logo') ? 'is-invalid' : '' }}"
                                   accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="file-hint">PNG / JPG · max 2 MB</p>
                        </div>

                        {{-- Description --}}
                        <div class="col-12">
                            <label class="field-label" for="description">Company Description</label>
                            <div class="input-group-styled {{ $errors->has('description') ? 'is-invalid' : '' }}">
                                <span class="ig-icon" style="align-self:flex-start; padding-top:.65rem">
                                    <i class="bi bi-chat-left-text"></i>
                                </span>
                                <textarea id="description" name="description" rows="2"
                                          placeholder="Brief description of what your company does…">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>{{-- /row --}}

                    {{-- ── Contact & Location ── --}}
                    <div class="form-section-title">Contact &amp; Location</div>

                    <div class="row g-3">

                        {{-- Official email --}}
                        <div class="col-md-6">
                            <label class="field-label" for="emp_email">
                                Official Email <span class="req">*</span>
                            </label>
                            <div class="input-group-styled {{ $errors->has('emp_email') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="emp_email" name="emp_email"
                                       value="{{ old('emp_email') }}"
                                       placeholder="info@company.rw" required>
                            </div>
                            @error('emp_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="file-hint">Login credentials will be sent here.</p>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="field-label" for="phone">Phone <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-telephone"></i></span>
                                <input type="text" id="phone" name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="+250 7XX XXX XXX" required>
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Province --}}
                        <div class="col-md-6">
                            <label class="field-label" for="province">Province <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('province') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-geo"></i></span>
                                <select id="province" name="province" required>
                                    <option value="">Select province…</option>
                                    @foreach ([
                                        'Kigali'   => 'Kigali City',
                                        'Northern' => 'Northern Province',
                                        'Southern' => 'Southern Province',
                                        'Eastern'  => 'Eastern Province',
                                        'Western'  => 'Western Province',
                                    ] as $val => $label)
                                        <option value="{{ $val }}" {{ old('province') === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- District --}}
                        <div class="col-md-6">
                            <label class="field-label" for="district">District <span class="req">*</span></label>
                            <div class="input-group-styled {{ $errors->has('district') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-pin-map"></i></span>
                                <input type="text" id="district" name="district"
                                       value="{{ old('district') }}"
                                       placeholder="e.g. Gasabo" required>
                            </div>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6">
                            <label class="field-label" for="address">Address</label>
                            <div class="input-group-styled {{ $errors->has('address') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-signpost"></i></span>
                                <input type="text" id="address" name="address"
                                       value="{{ old('address') }}"
                                       placeholder="Street / KG / KN / KK…">
                            </div>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Website --}}
                        <div class="col-md-6">
                            <label class="field-label" for="website">Website</label>
                            <div class="input-group-styled {{ $errors->has('website') ? 'is-invalid' : '' }}">
                                <span class="ig-icon"><i class="bi bi-globe"></i></span>
                                <input type="url" id="website" name="website"
                                       value="{{ old('website') }}"
                                       placeholder="https://company.rw">
                            </div>
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>{{-- /row --}}

                    <div class="mt-4">
                        <button type="submit" class="btn-submit" id="emp-submit">
                            <span class="btn-icon-wrap"><i class="bi bi-arrow-right"></i></span>
                            Submit Employer Registration
                        </button>
                        <p class="submit-note">
                            Your application will be reviewed. Login credentials will be emailed upon submission.
                        </p>
                    </div>

                </form>

            </div>{{-- /panel-employer --}}

        </div>{{-- /card-body-section --}}

        {{-- ── Trust bar ──────────────────────────────── --}}
        <div class="trust-bar">
            <div class="trust-dot"></div>
            <span class="trust-pill">TIN Verified</span>
            <div class="trust-dot"></div>
            <span class="trust-text">Secure registration &nbsp;·&nbsp; Official Government Platform &nbsp;·&nbsp; Rwanda</span>
        </div>

    </div>{{-- /reg-card --}}
</div>{{-- /reg-page --}}

{{-- Bootstrap JS (for dismissible alerts) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const panels  = ['government', 'employer'];
    const oldRole = '{{ old("role") }}';

    function selectRole(role) {
        panels.forEach(r => {
            document.getElementById('card-'  + r)?.classList.remove('selected');
            document.getElementById('panel-' + r)?.classList.remove('active');
        });
        document.getElementById('card-'  + role)?.classList.add('selected');
        document.getElementById('panel-' + role)?.classList.add('active');
        document.getElementById('role-prompt').style.display = 'none';
    }

    function resetRole() {
        panels.forEach(r => {
            document.getElementById('card-'  + r)?.classList.remove('selected');
            document.getElementById('panel-' + r)?.classList.remove('active');
        });
        document.getElementById('role-prompt').style.display = 'block';
    }

    // Restore role on validation-error redirect
    if (oldRole === 'government' || oldRole === 'employer') {
        selectRole(oldRole);
    }

    // Password visibility toggle
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    // Prevent double-submit
    document.getElementById('gov-form').addEventListener('submit', function () {
        const btn = document.getElementById('gov-submit');
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span>Creating account…`;
    });

    document.getElementById('employer-form').addEventListener('submit', function () {
        const btn = document.getElementById('emp-submit');
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status"></span>Submitting…`;
    });
</script>

</body>

</html>