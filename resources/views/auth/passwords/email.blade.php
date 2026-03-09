<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — NLREHVS</title>
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
            max-width: 460px;
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

        .info-box {
            background: #E8F0FB;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
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
        <h5 class="fw-bold mb-1">Reset Password</h5>
        <p class="mb-0" style="color:rgba(255,255,255,.75);font-size:.88rem;">
            National Labor Registration & Verification System
        </p>
    </div>

    {{-- Form Body --}}
    <div class="reset-body">

        {{-- Success Message --}}
        @if(session('status'))
        <div class="alert d-flex gap-2 mb-4"
             style="background:#E8F5EE;border-left:4px solid #1A7A4A;border-radius:10px;">
            <i class="bi bi-check-circle-fill text-success fs-5 flex-shrink-0 mt-1"></i>
            <div>
                <strong class="text-success small">Email Sent!</strong>
                <p class="mb-0 small text-muted">{{ session('status') }}</p>
            </div>
        </div>
        @endif

        {{-- Info Box --}}
        <div class="info-box">
            <div class="d-flex gap-2 align-items-start">
                <i class="bi bi-info-circle-fill text-primary mt-1 flex-shrink-0"></i>
                <small class="text-muted">
                    Enter your registered email address and we will send you
                    a link to reset your password.
                </small>
            </div>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
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

            {{-- Submit --}}
            <button type="submit" class="btn btn-reset mb-3">
                <i class="bi bi-send me-2"></i>Send Reset Link
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

</body>
</html>