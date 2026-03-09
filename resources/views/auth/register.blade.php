<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — NLREHVS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1B3A6B 0%, #2E6DB4 50%, #1A7A4A 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .register-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .25);
            width: 100%;
            max-width: 560px;
            overflow: hidden;
        }

        .register-top {
            background: linear-gradient(135deg, #1B3A6B, #2E6DB4);
            padding: 2rem;
            text-align: center;
            color: #fff;
        }

        .register-top .logo-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, .15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
        }

        .register-body {
            padding: 2rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1.5px solid #E5E7EB;
            padding: .65rem 1rem;
            font-size: .92rem;
            transition: all .2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2E6DB4;
            box-shadow: 0 0 0 3px rgba(46, 109, 180, .15);
        }

        .input-group-text {
            background: #F8FAFB;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px 0 0 10px;
            color: #6B7280;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }

        /* User Type Cards */
        .user-type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-bottom: 1.5rem;
        }

        .user-type-option input[type="radio"] {
            display: none;
        }

        .user-type-card {
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: #F8FAFB;
        }

        .user-type-card:hover {
            border-color: #2E6DB4;
            background: #E8F0FB;
        }

        .user-type-option input[type="radio"]:checked+.user-type-card {
            border-color: #1B3A6B;
            background: #E8F0FB;
            box-shadow: 0 0 0 3px rgba(27, 58, 107, .1);
        }

        .user-type-card .type-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto .6rem;
            font-size: 1.3rem;
        }

        .user-type-card .type-label {
            font-weight: 600;
            font-size: .88rem;
            color: #1a1a2e;
        }

        .user-type-card .type-desc {
            font-size: .75rem;
            color: #6B7280;
            margin-top: .2rem;
        }

        .user-type-option input:checked+.user-type-card .type-label {
            color: #1B3A6B;
        }

        /* Checkmark on selected */
        .user-type-option {
            position: relative;
        }

        .user-type-option input:checked+.user-type-card::after {
            content: '\F26E';
            font-family: 'bootstrap-icons';
            position: absolute;
            top: 8px;
            right: 10px;
            color: #1B3A6B;
            font-size: 1rem;
        }

        .btn-register {
            background: linear-gradient(135deg, #1B3A6B, #2E6DB4);
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-weight: 600;
            font-size: .95rem;
            width: 100%;
            color: #fff;
            transition: all .2s;
        }

        .btn-register:hover {
            opacity: .92;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(27, 58, 107, .3);
            color: #fff;
        }

        .divider {
            text-align: center;
            position: relative;
            margin: 1.2rem 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #E5E7EB;
        }

        .divider span {
            background: #fff;
            padding: 0 .75rem;
            position: relative;
            color: #9CA3AF;
            font-size: .82rem;
        }

        .form-label {
            font-weight: 600;
            font-size: .85rem;
            color: #374151;
            margin-bottom: .4rem;
        }

        .section-label {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9CA3AF;
            margin-bottom: .75rem;
        }
    </style>
</head>

<body>

    <div class="register-card">

        {{-- Top Banner --}}
        <div class="register-top">
            <div class="logo-icon">
                <i class="bi bi-shield-check" style="color:#4CAF50;"></i>
            </div>
            <h5 class="fw-bold mb-1">Create Your Account</h5>
            <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:.88rem;">
                National Labor Registration & Verification System
            </p>
        </div>

        {{-- Form Body --}}
        <div class="register-body">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Account Type --}}
                <div class="section-label">I am registering as</div>
                <div class="user-type-grid">

                    <label class="user-type-option">
                        <input type="radio"
                            name="user_type"
                            value="employee"
                            {{ old('user_type', 'employee') === 'employee' ? 'checked' : '' }}
                            required>
                        <div class="user-type-card">
                            <div class="type-icon" style="background:#E8F0FB;">
                                <i class="bi bi-person-badge" style="color:#1B3A6B;"></i>
                            </div>
                            <div class="type-label">Job Seeker</div>
                            <div class="type-desc">Employee / Worker</div>
                        </div>
                    </label>

                    <label class="user-type-option">
                        <input type="radio"
                            name="user_type"
                            value="employer"
                            {{ old('user_type') === 'employer' ? 'checked' : '' }}>
                        <div class="user-type-card">
                            <div class="type-icon" style="background:#E8F5EE;">
                                <i class="bi bi-building" style="color:#1A7A4A;"></i>
                            </div>
                            <div class="type-label">Employer</div>
                            <div class="type-desc">Company / Organization</div>
                        </div>
                    </label>

                </div>

                @error('user_type')
                <div class="text-danger small mb-3">{{ $message }}</div>
                @enderror

                <div class="divider"><span>Account Details</span></div>

                {{-- Full Name --}}
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Your full name"
                            value="{{ old('name') }}"
                            required autofocus>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Min. 8 characters"
                            required>
                        <button type="button"
                            class="btn btn-outline-secondary"
                            style="border-radius:0 10px 10px 0;border:1.5px solid #E5E7EB;border-left:none;"
                            onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Repeat your password"
                            required>
                        <button type="button"
                            class="btn btn-outline-secondary"
                            style="border-radius:0 10px 10px 0;border:1.5px solid #E5E7EB;border-left:none;"
                            onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-register mb-3">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </button>

                {{-- Login Link --}}
                <p class="text-center mb-0" style="font-size:.88rem;color:#6B7280;">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        style="color:#1B3A6B;font-weight:600;text-decoration:none;">
                        Sign in here
                    </a>
                </p>

            </form>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
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