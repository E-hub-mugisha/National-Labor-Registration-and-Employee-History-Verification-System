<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — NLREHVS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1B3A6B 0%, #2E6DB4 50%, #1A7A4A 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,.25);
            width: 100%;
            max-width: 460px;
            overflow: hidden;
        }

        .login-top {
            background: linear-gradient(135deg, #1B3A6B, #2E6DB4);
            padding: 2rem;
            text-align: center;
            color: #fff;
        }

        .login-top .logo-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,.15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #E5E7EB;
            padding: .65rem 1rem;
            font-size: .92rem;
            transition: all .2s;
        }

        .form-control:focus {
            border-color: #2E6DB4;
            box-shadow: 0 0 0 3px rgba(46,109,180,.15);
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

        .btn-login {
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

        .btn-login:hover {
            opacity: .92;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(27,58,107,.3);
            color: #fff;
        }

        .form-label {
            font-weight: 600;
            font-size: .85rem;
            color: #374151;
            margin-bottom: .4rem;
        }

        .form-check-input:checked {
            background-color: #1B3A6B;
            border-color: #1B3A6B;
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

        .quick-access {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .5rem;
            margin-bottom: 1.5rem;
        }

        .quick-card {
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            padding: .75rem;
            text-align: center;
            font-size: .8rem;
            color: #6B7280;
            background: #F8FAFB;
        }

        .quick-card i {
            display: block;
            font-size: 1.2rem;
            margin-bottom: .3rem;
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- Top Banner --}}
    <div class="login-top">
        <div class="logo-icon">
            <i class="bi bi-shield-check" style="color:#4CAF50;"></i>
        </div>
        <h5 class="fw-bold mb-1">Welcome Back</h5>
        <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:.88rem;">
            National Labor Registration & Verification System
        </p>
    </div>

    {{-- Form Body --}}
    <div class="login-body">

        {{-- Quick Access Info --}}
        <div class="quick-access">
            <div class="quick-card">
                <i class="bi bi-person-badge" style="color:#1B3A6B;"></i>
                Job Seekers
            </div>
            <div class="quick-card">
                <i class="bi bi-building" style="color:#1A7A4A;"></i>
                Employers
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                           required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0">Password</label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           style="font-size:.82rem;color:#2E6DB4;text-decoration:none;">
                            Forgot password?
                        </a>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter your password"
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

            {{-- Remember Me --}}
            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox"
                           name="remember"
                           id="remember"
                           class="form-check-input"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label"
                           for="remember"
                           style="font-size:.88rem;color:#6B7280;">
                        Keep me signed in
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-login mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>

            {{-- Register Link --}}
            <p class="text-center mb-0" style="font-size:.88rem;color:#6B7280;">
                Don't have an account?
                <a href="{{ route('register') }}"
                   style="color:#1B3A6B;font-weight:600;text-decoration:none;">
                    Create one here
                </a>
            </p>

        </form>
    </div>
</div>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const icon  = btn.querySelector('i');
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