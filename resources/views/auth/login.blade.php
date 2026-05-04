<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — EmpRecord Rwanda</title>

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
            --navy: #0b1f3a;
            --navy-mid: #132d52;
            --navy-light: #1a3d6e;
            --gold: #c4922a;
            --gold-light: #e8b84b;
            --gold-pale: #fdf3e0;
            --slate: #4a5f7a;
            --border-soft: rgba(196, 146, 42, .2);
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'DM Sans', system-ui, sans-serif;
        }

        /* ═══════════════════════════════════════════
           PAGE / BACKGROUND
        ═══════════════════════════════════════════ */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            min-height: 100vh;
            background: linear-gradient(155deg, var(--navy) 0%, var(--navy-mid) 55%, var(--navy-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Rwanda flag bar — top of viewport */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg,
                    #20603d 0%, #20603d 33%,
                    #e5be01 33%, #e5be01 66%,
                    #169cda 66%, #169cda 100%);
            z-index: 100;
        }

        /* Gold grid overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(196, 146, 42, .07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(196, 146, 42, .07) 1px, transparent 1px);
            background-size: 44px 44px;
            pointer-events: none;
            z-index: 0;
        }

        /* Radial gold glow */
        .bg-glow {
            position: fixed;
            top: -15%;
            right: -10%;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(196, 146, 42, .13) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ═══════════════════════════════════════════
           LOGIN CARD
        ═══════════════════════════════════════════ */
        .login-card {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            max-width: 430px;
            overflow: hidden;
            border: 1px solid rgba(196, 146, 42, .2);
            box-shadow: 0 32px 80px rgba(0, 0, 0, .35), 0 0 0 1px rgba(196, 146, 42, .08);
            position: relative;
            z-index: 1;
        }

        /* ── Card header ── */
        .card-header-band {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 60%, var(--navy-light) 100%);
            padding: 1.85rem 2rem 1.6rem;
            position: relative;
            overflow: hidden;
        }

        /* Inner grid on header */
        .card-header-band::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(196, 146, 42, .09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(196, 146, 42, .09) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: .7rem;
            margin-bottom: 1.25rem;
            position: relative;
            z-index: 1;
        }

        .logo-mark {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--navy);
            flex-shrink: 0;
        }

        .logo-text {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.1;
        }

        .logo-text small {
            display: block;
            font-size: .6rem;
            font-weight: 400;
            letter-spacing: .12em;
            color: var(--gold-light);
            text-transform: uppercase;
            font-family: var(--font-body);
        }

        .card-headline {
            font-family: var(--font-display);
            font-size: 1.7rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: .3rem;
            position: relative;
            z-index: 1;
        }

        .card-headline em {
            color: var(--gold-light);
            font-style: italic;
        }

        .card-subline {
            font-size: .77rem;
            color: rgba(255, 255, 255, .48);
            font-weight: 300;
            letter-spacing: .02em;
            position: relative;
            z-index: 1;
        }

        /* ── Card body ── */
        .card-body-section {
            padding: 1.85rem 2rem 1.5rem;
        }

        /* ── Field labels ── */
        .field-label {
            display: block;
            font-size: .72rem;
            font-weight: 500;
            color: var(--slate);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: .4rem;
        }

        /* ── Input group ── */
        .input-group {
            border: 1.5px solid #dde3ec;
            border-radius: 8px;
            overflow: hidden;
            transition: border-color .2s, box-shadow .2s;
            display: flex;
            align-items: stretch;
        }

        .input-group:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(196, 146, 42, .12);
        }

        .input-group.is-invalid-group {
            border-color: #dc3545;
        }

        .input-group .input-icon {
            width: 40px;
            background: #f6f4f0;
            border-right: 1.5px solid #dde3ec;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #8a9ab5;
            font-size: .9rem;
        }

        .input-group input {
            flex: 1;
            border: none;
            outline: none;
            padding: .65rem .9rem;
            font-size: .88rem;
            font-family: var(--font-body);
            color: var(--navy);
            background: #fff;
            min-width: 0;
        }

        .input-group input::placeholder {
            color: #b0bac8;
        }

        .input-group .toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0 .75rem;
            color: #8a9ab5;
            display: flex;
            align-items: center;
            font-size: .9rem;
            transition: color .2s;
        }

        .input-group .toggle-btn:hover {
            color: var(--gold);
        }

        /* Bootstrap invalid feedback outside group */
        .invalid-feedback {
            font-size: .78rem;
            margin-top: .3rem;
        }

        /* ── Remember / forgot row ── */
        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem;
        }

        .form-check-input:checked {
            background-color: var(--navy);
            border-color: var(--navy);
        }

        .form-check-label {
            font-size: .82rem;
            color: #6b7d96;
            cursor: pointer;
        }

        .forgot-link {
            font-size: .78rem;
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: color .2s;
        }

        .forgot-link:hover {
            color: var(--gold-light);
            text-decoration: underline;
        }

        /* ── Submit button ── */
        .btn-signin {
            width: 100%;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
            border: none;
            border-radius: 8px;
            padding: .72rem 1rem;
            color: #fff;
            font-family: var(--font-body);
            font-size: .9rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            letter-spacing: .02em;
            transition: opacity .2s, transform .15s, box-shadow .2s;
        }

        .btn-signin:hover {
            opacity: .92;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(11, 31, 58, .35);
        }

        .btn-signin:active {
            transform: translateY(0);
        }

        .btn-icon-wrap {
            width: 22px;
            height: 22px;
            background: rgba(196, 146, 42, .22);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            color: var(--gold-light);
        }

        /* ── Divider ── */
        .divider {
            text-align: center;
            position: relative;
            margin: 1.25rem 0 1rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #eaebf0;
        }

        .divider span {
            background: #fff;
            padding: 0 .75rem;
            position: relative;
            color: #b0bac8;
            font-size: .74rem;
        }

        /* ── Register note ── */
        .register-note {
            text-align: center;
            font-size: .8rem;
            color: #8a9ab5;
        }

        .register-note a {
            color: var(--navy);
            font-weight: 500;
            text-decoration: none;
        }

        .register-note a:hover {
            color: var(--gold);
        }

        /* ── Trust footer bar ── */
        .trust-bar {
            background: var(--gold-pale);
            border-top: 1px solid rgba(196, 146, 42, .2);
            padding: .65rem 2rem;
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .trust-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
        }

        .trust-pill {
            background: rgba(196, 146, 42, .12);
            border: 1px solid rgba(196, 146, 42, .3);
            color: #854f0b;
            font-size: .65rem;
            font-weight: 500;
            padding: .15rem .55rem;
            border-radius: 20px;
            white-space: nowrap;
        }

        .trust-text {
            font-size: .7rem;
            color: #7a6040;
        }

        /* ── Alert (session errors) ── */
        .alert-gold {
            background: rgba(196, 146, 42, .08);
            border: 1px solid rgba(196, 146, 42, .3);
            border-radius: 8px;
            padding: .7rem .9rem;
            font-size: .82rem;
            color: #6b4c10;
            margin-bottom: 1.1rem;
        }

        .alert-gold ul {
            margin: 0;
            padding-left: 1rem;
        }
    </style>
</head>

<body>

    <div class="bg-glow"></div>

    <div class="login-card">

        {{-- ── Card header ── --}}
        <div class="card-header-band">
            <div class="logo-row">
                <div class="logo-mark">ER</div>
                <div class="logo-text">
                    EmpRecord
                    <small>Rwanda</small>
                </div>
            </div>
            <h1 class="card-headline">Welcome <em>Back</em></h1>
            <p class="card-subline">National Labour Registration &amp; Employment Verification System</p>
        </div>

        {{-- ── Form body ── --}}
        <div class="card-body-section">

            {{-- Session error bag (e.g. throttle) --}}
            @if ($errors->any())
            <div class="alert-gold">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="field-label">Email address</label>
                    <div class="input-group {{ $errors->has('email') ? 'is-invalid-group' : '' }}">
                        <span class="input-icon">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            autocomplete="email"
                            autofocus
                            required>
                    </div>
                    @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label for="password" class="field-label mb-0">Password</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Forgot password?
                        </a>
                        @endif
                    </div>
                    <div class="input-group {{ $errors->has('password') ? 'is-invalid-group' : '' }}">
                        <span class="input-icon">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required>
                        <button type="button" class="toggle-btn" onclick="togglePassword()" aria-label="Toggle password visibility">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember me + submit --}}
                <div class="meta-row">
                    <div class="form-check mb-0">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="remember"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Keep me signed in
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-signin">
                    <span class="btn-icon-wrap">
                        <i class="bi bi-arrow-right"></i>
                    </span>
                    Sign In to Your Account
                </button>

            </form>

            <div class="divider"><span>New to the platform?</span></div>

            <p class="register-note">
                Don't have an account?
                <a href="{{ route('register') }}">Create one here</a>
            </p>

        </div>

        {{-- ── Trust footer bar ── --}}
        <div class="trust-bar">
            <div class="trust-dot"></div>
            <span class="trust-pill">TIN Verified</span>
            <div class="trust-dot"></div>
            <span class="trust-text">End-to-end verified records &nbsp;·&nbsp; Official Government Platform</span>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>

</body>

</html>