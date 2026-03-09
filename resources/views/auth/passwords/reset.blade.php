<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password — NLREHVS</title>
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

        .reset-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,.25);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }

        .reset-top {
            background: linear-gradient(135deg, #1B3A6B, #2E6DB4);
            padding: 2rem;
            text-align: center;
            color: #fff;
        }

        .reset-top .logo-icon {
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

        .reset-body {
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

        .btn-reset {
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

        .btn-reset:hover {
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

        .password-strength {
            height: 4px;
            border-radius: 4px;
            background: #E5E7EB;
            margin-top: .4rem;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            border-radius: 4px;
            width: 0%;
            transition: all .3s;
        }
    </style>
</head>
<body>

<div class="reset-card">

    {{-- Top Banner --}}
    <div class="reset-top">
        <div class="logo-icon">
            <i class="bi bi-shield-check" style="color:#4CAF50;"></i>
        </div>
        <h5 class="fw-bold mb-1">Set New Password</h5>
        <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:.88rem;">
            National Labor Registration & Verification System
        </p>
    </div>

    {{-- Form Body --}}
    <div class="reset-body">

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

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
                           value="{{ $email ?? old('email') }}"
                           required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- New Password --}}
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Min. 8 characters"
                           required
                           oninput="checkStrength(this.value)">
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
                {{-- Strength Bar --}}
                <div class="password-strength mt-2">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <small id="strengthText" class="text-muted"></small>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label class="form-label">Confirm New Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control"
                           placeholder="Repeat new password"
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
            <button type="submit" class="btn btn-reset mb-3">
                <i class="bi bi-check-circle me-2"></i>Reset Password
            </button>

            {{-- Back to Login --}}
            <p class="text-center mb-0" style="font-size:.88rem;color:#6B7280;">
                Remember your password?
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
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    function checkStrength(val) {
        const bar  = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        let score  = 0;

        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))     score++;

        const levels = [
            { w: '0%',   bg: '',          label: '' },
            { w: '25%',  bg: '#DC2626',   label: 'Weak' },
            { w: '50%',  bg: '#D97706',   label: 'Fair' },
            { w: '75%',  bg: '#2E6DB4',   label: 'Good' },
            { w: '100%', bg: '#1A7A4A',   label: 'Strong' },
        ];

        bar.style.width      = levels[score].w;
        bar.style.background = levels[score].bg;
        text.textContent     = levels[score].label;
        text.style.color     = levels[score].bg;
    }
</script>

</body>
</html>