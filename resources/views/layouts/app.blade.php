<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NLREHVS') — National Labor Registry</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1B3A6B;
            --secondary: #2E6DB4;
            --accent: #1A7A4A;
            --light-blue: #E8F0FB;
            --light-green: #E8F5EE;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8FAFB;
            color: #1a1a2e;
        }

        /* ── Navbar ── */
        .navbar {
            background: var(--primary) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .2);
        }

        .navbar-brand .logo-text {
            font-weight: 700;
            color: #fff;
            font-size: 1.1rem;
        }

        .navbar-brand .logo-sub {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, .7);
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--primary);
            position: fixed;
            top: 56px;
            left: 0;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .75);
            padding: .65rem 1.5rem;
            transition: all .2s;
            font-size: .9rem;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, .12);
            border-left: 3px solid #4CAF50;
        }

        .sidebar .nav-section {
            color: rgba(255, 255, 255, .45);
            font-size: .7rem;
            text-transform: uppercase;
            padding: 1rem 1.5rem .3rem;
            letter-spacing: .08em;
        }

        /* ── Main Content ── */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            margin-top: 56px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* ── Cards ── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* ── Badges ── */
        .badge-verified {
            background: #d1fae5;
            color: #065f46;
            font-size: .72rem;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
            font-size: .72rem;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
            font-size: .72rem;
        }

        /* ── Misc ── */
        .rating-star {
            color: #f59e0b;
        }

        .nida-badge {
            background: var(--light-blue);
            color: var(--primary);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
        }

        .section-header {
            background: var(--light-blue);
            border-radius: 8px;
            padding: .75rem 1rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--secondary);
        }

        .timeline-item {
            border-left: 3px solid var(--secondary);
            padding-left: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: #152d55;
            border-color: #152d55;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ── Top Navbar ── --}}
    <nav class="navbar navbar-dark fixed-top px-3">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <div style="background:rgba(255,255,255,.15);border-radius:8px;padding:6px 10px;">
                <i class="bi bi-shield-check" style="font-size:1.3rem;color:#4CAF50;"></i>
            </div>
            <div>
                <div class="logo-text">NLREHVS</div>
                <div class="logo-sub">National Labor Registry · Rwanda</div>
            </div>
        </a>

        <div class="d-flex align-items-center gap-3 ms-auto">
            @auth
            <span class="text-white-50 small d-none d-md-inline">
                {{ Auth::user()->name }}
                <span class="badge bg-secondary ms-1">
                    {{ Auth::user()->user_type }}
                </span>
            </span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <a href="#" class="btn btn-sm btn-outline-light"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Login</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-light">Register</a>
            @endauth
        </div>
    </nav>

    <div class="d-flex">

        {{-- ── Sidebar ── --}}
        @auth
        <nav class="sidebar pt-3">

            @if(Auth::user()->user_type === 'employee')
            <div class="nav-section">Employee</div>
            <a href="{{ route('employee.dashboard') }}"
                class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
            <a href="{{ route('employee.profile') }}"
                class="nav-link {{ request()->routeIs('employee.profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-2"></i>My Profile
            </a>
            <div class="nav-section mt-2">History</div>
            <a href="{{ route('employee.feedback.index') }}"
                class="nav-link {{ request()->routeIs('employee.feedback.index') ? 'active' : '' }}">
                <i class="bi bi-star me-2"></i>My Feedback
            </a>

            @elseif(Auth::user()->user_type === 'employer')
            <div class="nav-section">Employer</div>
            <a href="{{ route('employer.dashboard') }}"
                class="nav-link {{ request()->routeIs('employer.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
            <div class="nav-section mt-2">Workforce</div>
            <a href="{{ route('employer.dashboard') }}"
                class="nav-link {{ request()->routeIs('employer.dashboard') ? 'active' : '' }}">
                <i class="bi bi-person-plus me-2"></i>Report New Hire
            </a>
            <div class="nav-section mt-2">Verification</div>
            <a href="{{ route('employer.verify.index') }}"
                class="nav-link {{ request()->routeIs('employer.verify*') ? 'active' : '' }}">
                <i class="bi bi-search me-2"></i>Search Employee
            </a>

            @elseif(in_array(Auth::user()->user_type, ['admin', 'government']))
            <div class="nav-section">Administration</div>
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
            <div class="nav-section mt-2">Registry</div>
            <a href="{{ route('admin.employees.index') }}"
                class="nav-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>Employees
            </a>
            <a href="{{ route('admin.employers.index') }}"
                class="nav-link {{ request()->routeIs('admin.employers*') ? 'active' : '' }}">
                <i class="bi bi-building me-2"></i>Employers
            </a>
            <div class="nav-section mt-2">Moderation</div>
            <a href="{{ route('admin.feedback.index') }}"
                class="nav-link {{ request()->routeIs('admin.feedback*') ? 'active' : '' }}">
                <i class="bi bi-flag me-2"></i>Feedback Review
            </a>
            <div class="nav-section mt-2">Insights</div>
            <a href="{{ route('admin.statistics') }}"
                class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                <i class="bi bi-bar-chart me-2"></i>Statistics
            </a>
            <a href="{{ route('admin.audit-log') }}"
                class="nav-link {{ request()->routeIs('admin.audit-log') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-2"></i>Audit Log
            </a>
            @endif

        </nav>
        @endauth

        {{-- ── Main Content ── --}}
        <main class="{{ Auth::check() ? 'main-content' : 'container py-5' }} w-100">

            {{-- Flash Messages --}}
            @foreach(['success','error','info','warning'] as $type)
            @if(session($type))
            <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show mb-3">
                <i class="bi bi-{{ $type === 'success' ? 'check-circle' : ($type === 'error' ? 'exclamation-triangle' : 'info-circle') }} me-2"></i>
                {{ session($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @endforeach

            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>