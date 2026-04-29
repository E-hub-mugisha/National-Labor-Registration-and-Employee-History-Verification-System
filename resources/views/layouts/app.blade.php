<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NLREHVS') — National Labor Registry</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════
           DESIGN TOKENS
        ═══════════════════════════════════════ */
        :root {
            --navy-900: #0A1628;
            --navy-800: #0F2040;
            --navy-700: #162B52;
            --navy-600: #1E3A6E;
            --navy-500: #2B4F8C;
            --green-600: #007A3D;
            --green-500: #009E4F;
            --green-400: #00B85A;
            --green-100: #E6F7EE;
            --blue-100: #EBF2FF;
            --amber-500: #F59E0B;
            --red-500:  #DC2626;
            --slate-50: #F8FAFC;
            --slate-100: #F1F5F9;
            --slate-200: #E2E8F0;
            --slate-400: #94A3B8;
            --slate-600: #475569;
            --slate-800: #1E293B;
            --white: #FFFFFF;
            --sidebar-w: 262px;
            --topbar-h: 60px;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.05);
            --shadow-md: 0 4px 16px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.05);
            --shadow-lg: 0 10px 32px rgba(0,0,0,.12), 0 2px 8px rgba(0,0,0,.06);
            --transition: all .18s cubic-bezier(.4,0,.2,1);
        }

        /* ═══════════════════════════════════════
           RESET & BASE
        ═══════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--slate-50);
            color: var(--slate-800);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══════════════════════════════════════
           TOP NAVBAR
        ═══════════════════════════════════════ */
        .topbar {
            height: var(--topbar-h);
            background: var(--navy-800);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1050;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,.25);
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--green-500), var(--green-400));
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(0,158,79,.25);
        }

        .brand-text-main {
            font-size: .95rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: .01em;
            line-height: 1.2;
        }

        .brand-text-sub {
            font-size: .68rem;
            color: rgba(255,255,255,.5);
            letter-spacing: .03em;
            line-height: 1;
        }

        /* Topbar divider */
        .topbar-divider {
            width: 1px;
            height: 24px;
            background: rgba(255,255,255,.12);
            margin: 0 1rem;
        }

        /* Topbar right side */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-left: auto;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .35rem .75rem .35rem .5rem;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.1);
        }

        .topbar-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--navy-600), var(--navy-500));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .topbar-user-name {
            font-size: .8rem;
            font-weight: 600;
            color: rgba(255,255,255,.9);
            max-width: 140px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .topbar-role-badge {
            font-size: .65rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
            background: rgba(0,158,79,.25);
            color: #6EE7A8;
            letter-spacing: .02em;
            text-transform: capitalize;
        }

        .btn-topbar {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .38rem .85rem;
            font-size: .78rem;
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-logout {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            color: rgba(255,255,255,.8);
            text-decoration: none;
        }

        .btn-logout:hover {
            background: rgba(220,38,38,.2);
            border-color: rgba(220,38,38,.4);
            color: #FCA5A5;
        }

        .btn-login {
            background: transparent;
            border: 1px solid rgba(255,255,255,.25);
            color: rgba(255,255,255,.85);
            text-decoration: none;
        }

        .btn-login:hover {
            background: rgba(255,255,255,.1);
            color: #fff;
        }

        .btn-register {
            background: var(--green-500);
            border: 1px solid var(--green-400);
            color: #fff;
            text-decoration: none;
        }

        .btn-register:hover {
            background: var(--green-400);
            color: #fff;
        }

        /* Mobile toggle */
        .sidebar-toggle {
            display: none;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.15);
            color: #fff;
            width: 34px;
            height: 34px;
            border-radius: var(--radius-sm);
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            margin-right: .75rem;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--navy-900);
            position: fixed;
            top: var(--topbar-h);
            left: 0;
            bottom: 0;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,.05);
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.1) transparent;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 2px; }

        /* Sidebar section labels */
        .sidebar-section {
            padding: 1.4rem 1.2rem .4rem;
        }

        .sidebar-section-label {
            font-size: .63rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .sidebar-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,.07);
        }

        /* Sidebar nav items */
        .sidebar-nav {
            padding: 0 .75rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem .85rem;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: .83rem;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 2px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,.07);
            color: rgba(255,255,255,.9);
        }

        .sidebar-link.active {
            background: rgba(0,158,79,.15);
            color: #fff;
            font-weight: 600;
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: var(--green-400);
            border-radius: 0 3px 3px 0;
        }

        .sidebar-link .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            flex-shrink: 0;
            opacity: .75;
        }

        .sidebar-link.active .nav-icon,
        .sidebar-link:hover .nav-icon {
            opacity: 1;
        }

        .sidebar-link .nav-icon.active-icon {
            color: var(--green-400);
        }

        /* Sidebar footer */
        .sidebar-footer {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,.06);
        }

        .sidebar-footer-info {
            font-size: .68rem;
            color: rgba(255,255,255,.25);
            text-align: center;
            line-height: 1.6;
        }

        /* ═══════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════ */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            padding: 1.75rem 2rem;
            min-height: calc(100vh - var(--topbar-h));
        }

        .guest-content {
            margin-top: var(--topbar-h);
            padding: 2.5rem 1.5rem;
        }

        /* ═══════════════════════════════════════
           FLASH ALERTS
        ═══════════════════════════════════════ */
        .flash-alert {
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            padding: .875rem 1.1rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.25rem;
            font-size: .83rem;
            font-weight: 500;
            border: 1px solid transparent;
            animation: slideDown .25s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .flash-alert .flash-icon {
            font-size: 1rem;
            margin-top: .05rem;
            flex-shrink: 0;
        }

        .flash-alert .flash-body { flex: 1; }

        .flash-alert .btn-close {
            width: 20px;
            height: 20px;
            padding: 0;
            margin-top: .05rem;
            flex-shrink: 0;
            opacity: .5;
        }

        .flash-success {
            background: #ECFDF5;
            border-color: #A7F3D0;
            color: #065F46;
        }

        .flash-success .flash-icon { color: #059669; }

        .flash-danger {
            background: #FEF2F2;
            border-color: #FECACA;
            color: #991B1B;
        }

        .flash-danger .flash-icon { color: #DC2626; }

        .flash-warning {
            background: #FFFBEB;
            border-color: #FDE68A;
            color: #92400E;
        }

        .flash-warning .flash-icon { color: #D97706; }

        .flash-info {
            background: #EFF6FF;
            border-color: #BFDBFE;
            color: #1E40AF;
        }

        .flash-info .flash-icon { color: #3B82F6; }

        /* ═══════════════════════════════════════
           REUSABLE COMPONENTS
        ═══════════════════════════════════════ */

        /* Page header */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--slate-800);
            margin: 0;
            line-height: 1.3;
        }

        .page-subtitle {
            font-size: .82rem;
            color: var(--slate-400);
            margin: .2rem 0 0;
        }

        /* Breadcrumb */
        .breadcrumb {
            font-size: .75rem;
            margin-bottom: .4rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--slate-400);
        }

        .breadcrumb-item a {
            color: var(--navy-600);
            text-decoration: none;
        }

        .breadcrumb-item a:hover { text-decoration: underline; }
        .breadcrumb-item.active { color: var(--slate-400); }

        /* Cards */
        .card {
            border: 1px solid var(--slate-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            background: #fff;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--slate-200);
            padding: 1rem 1.25rem;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .card-header-title {
            font-weight: 700;
            font-size: .9rem;
            color: var(--slate-800);
        }

        .card-body { padding: 1.25rem; }

        /* Stat cards */
        .stat-card {
            border: 1px solid var(--slate-200);
            border-radius: var(--radius-lg);
            background: #fff;
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.7rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--slate-800);
        }

        .stat-label {
            font-size: .78rem;
            color: var(--slate-400);
            font-weight: 500;
        }

        .stat-change {
            font-size: .73rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 20px;
        }

        .stat-change.up   { background: #ECFDF5; color: #059669; }
        .stat-change.down { background: #FEF2F2; color: #DC2626; }

        /* Badges */
        .badge-verified {
            background: #D1FAE5;
            color: #065F46;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: .02em;
        }

        .badge-pending {
            background: #FEF3C7;
            color: #92400E;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: .02em;
        }

        .badge-rejected {
            background: #FEE2E2;
            color: #991B1B;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: .02em;
        }

        /* NIDA badge */
        .nida-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: var(--blue-100);
            color: var(--navy-600);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .02em;
        }

        /* Section divider */
        .section-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.5rem 0 1rem;
        }

        .section-divider-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--slate-400);
            white-space: nowrap;
        }

        .section-divider::before, .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--slate-200);
        }

        /* Tables */
        .table { font-size: .83rem; }
        .table thead th {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--slate-400);
            border-bottom: 1px solid var(--slate-200);
            padding: .75rem 1rem;
            background: var(--slate-50);
        }

        .table tbody td {
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--slate-100);
            vertical-align: middle;
        }

        .table tbody tr:hover td { background: var(--slate-50); }
        .table tbody tr:last-child td { border-bottom: none; }

        /* Buttons */
        .btn {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            font-size: .82rem;
        }

        .btn-primary {
            background: var(--navy-600);
            border-color: var(--navy-600);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--navy-700);
            border-color: var(--navy-700);
            color: #fff;
        }

        .btn-success {
            background: var(--green-500);
            border-color: var(--green-500);
            color: #fff;
        }

        .btn-success:hover {
            background: var(--green-600);
            border-color: var(--green-600);
            color: #fff;
        }

        .btn-outline-primary {
            color: var(--navy-600);
            border-color: var(--navy-600);
        }

        .btn-outline-primary:hover {
            background: var(--navy-600);
            border-color: var(--navy-600);
        }

        /* Form controls */
        .form-control, .form-select {
            font-size: .83rem;
            border-color: var(--slate-200);
            border-radius: var(--radius-sm);
            color: var(--slate-800);
            padding: .5rem .75rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--navy-500);
            box-shadow: 0 0 0 3px rgba(30,58,110,.12);
        }

        .form-label {
            font-size: .78rem;
            font-weight: 600;
            color: var(--slate-600);
            margin-bottom: .35rem;
        }

        /* Timeline */
        .timeline-item {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: .4rem;
            bottom: -1.1rem;
            width: 2px;
            background: var(--slate-200);
        }

        .timeline-item:last-child::before { display: none; }

        .timeline-dot {
            position: absolute;
            left: -4px;
            top: .3rem;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--navy-600);
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px var(--navy-600);
        }

        /* Rating stars */
        .rating-star { color: #F59E0B; }

        /* ═══════════════════════════════════════
           MOBILE OVERLAY
        ═══════════════════════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1039;
            backdrop-filter: blur(2px);
        }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 24px rgba(0,0,0,.25);
            }

            .sidebar-overlay.visible { display: block; }

            .sidebar-toggle { display: flex; }

            .main-content {
                margin-left: 0 !important;
                padding: 1.25rem;
            }

            .topbar-user-name { display: none; }
            .topbar-divider { display: none; }
        }

        @media (max-width: 575.98px) {
            .main-content { padding: 1rem; }
            .page-title { font-size: 1.15rem; }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ══════════════════════════════════
         TOP NAVBAR
    ══════════════════════════════════ --}}
    <header class="topbar">

        @auth
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        @endauth

        <a class="brand" href="{{ route('home') }}">
            <div class="brand-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <div class="brand-text-main">NLREHVS</div>
                <div class="brand-text-sub">National Labor Registry &middot; Rwanda</div>
            </div>
        </a>

        <div class="topbar-divider d-none d-md-block"></div>

        <div class="topbar-right">
            @auth
            <div class="topbar-user d-none d-sm-flex">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="topbar-user-name">{{ Auth::user()->name }}</div>
                </div>
                <span class="topbar-role-badge">{{ Auth::user()->role }}</span>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
            <a href="#" class="btn-topbar btn-logout"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span class="d-none d-md-inline">Sign out</span>
            </a>
            @else
            <a href="{{ route('login') }}"    class="btn-topbar btn-login">
                <i class="bi bi-person"></i> Login
            </a>
            <a href="{{ route('register') }}" class="btn-topbar btn-register">
                <i class="bi bi-person-plus"></i> Register
            </a>
            @endauth
        </div>
    </header>

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div style="display:flex;">

        {{-- ══════════════════════════════════
             SIDEBAR
        ══════════════════════════════════ --}}
        @auth
        <aside class="sidebar" id="sidebar">

            @if(Auth::user()->role === 'employee')

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Employee Portal</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('employee.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('employee.dashboard') ? 'active-icon' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                        </span>
                        Dashboard
                    </a>
                    <a href="{{ route('employee.profile') }}"
                       class="sidebar-link {{ request()->routeIs('employee.profile') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('employee.profile') ? 'active-icon' : '' }}">
                            <i class="bi bi-person-circle"></i>
                        </span>
                        My Profile
                    </a>
                </nav>

                <div class="sidebar-section">
                    <div class="sidebar-section-label">History</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('employee.records.index') }}"
                       class="sidebar-link {{ request()->routeIs('employee.records.index') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('employee.records.index') ? 'active-icon' : '' }}">
                            <i class="bi bi-file-text"></i>
                        </span>
                        My Records
                    </a>
                </nav>

            @elseif(Auth::user()->role === 'employer')

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Employer Portal</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('employer.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('employer.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('employer.dashboard') ? 'active-icon' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                        </span>
                        Dashboard
                    </a>
                </nav>

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Workforce</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('employees.index') }}"
                       class="sidebar-link {{ request()->routeIs('employees.index') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('employees.index') ? 'active-icon' : '' }}">
                            <i class="bi bi-people"></i>
                        </span>
                        All Employees
                    </a>
                    <a href="{{ route('employees.search') }}"
                       class="sidebar-link {{ request()->routeIs('employees.search') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('employees.search') ? 'active-icon' : '' }}">
                            <i class="bi bi-search"></i>
                        </span>
                        ID Search
                    </a>
                    <a href="{{ route('employees.create') }}"
                       class="sidebar-link {{ request()->routeIs('employees.create') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('employees.create') ? 'active-icon' : '' }}">
                            <i class="bi bi-person-plus"></i>
                        </span>
                        New Employee
                    </a>
                </nav>

            @elseif(in_array(Auth::user()->role, ['admin', 'government']))

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Administration</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('admin.dashboard') ? 'active-icon' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                        </span>
                        Dashboard
                    </a>
                </nav>

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Registry</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('admin.employees.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('admin.employees*') ? 'active-icon' : '' }}">
                            <i class="bi bi-people"></i>
                        </span>
                        Employees
                    </a>
                    <a href="{{ route('admin.employers.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.employers*') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('admin.employers*') ? 'active-icon' : '' }}">
                            <i class="bi bi-building"></i>
                        </span>
                        Employers
                    </a>
                </nav>

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Moderation</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('gov.claims.index') }}"
                       class="sidebar-link {{ request()->routeIs('gov.claims*') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('gov.claims*') ? 'active-icon' : '' }}">
                            <i class="bi bi-flag"></i>
                        </span>
                        Claims Review
                    </a>
                </nav>

                <div class="sidebar-section">
                    <div class="sidebar-section-label">Insights</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="{{ route('admin.statistics') }}"
                       class="sidebar-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('admin.statistics') ? 'active-icon' : '' }}">
                            <i class="bi bi-bar-chart-line"></i>
                        </span>
                        Statistics
                    </a>
                    <a href="{{ route('admin.audit-log') }}"
                       class="sidebar-link {{ request()->routeIs('admin.audit-log') ? 'active' : '' }}">
                        <span class="nav-icon {{ request()->routeIs('admin.audit-log') ? 'active-icon' : '' }}">
                            <i class="bi bi-journal-text"></i>
                        </span>
                        Audit Log
                    </a>
                </nav>

            @endif

            <div class="sidebar-footer">
                <div class="sidebar-footer-info">
                    National Labor Registry<br>
                    &copy; {{ date('Y') }} Republic of Rwanda
                </div>
            </div>

        </aside>
        @endauth

        {{-- ══════════════════════════════════
             MAIN CONTENT
        ══════════════════════════════════ --}}
        <main class="{{ Auth::check() ? 'main-content' : 'guest-content container' }} w-100">

            {{-- Flash Messages --}}
            @foreach(['success','error','info','warning'] as $type)
                @if(session($type))
                    @php
                        $icons = [
                            'success' => 'check-circle-fill',
                            'error'   => 'exclamation-triangle-fill',
                            'warning' => 'exclamation-circle-fill',
                            'info'    => 'info-circle-fill',
                        ];
                        $cls = $type === 'error' ? 'danger' : $type;
                    @endphp
                    <div class="flash-alert flash-{{ $cls }}" role="alert">
                        <i class="bi bi-{{ $icons[$type] }} flash-icon"></i>
                        <div class="flash-body">{{ session($type) }}</div>
                        <button type="button" class="btn-close" onclick="this.closest('.flash-alert').remove()" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar mobile toggle
        const toggle  = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar?.classList.add('open');
            overlay?.classList.add('visible');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar?.classList.remove('open');
            overlay?.classList.remove('visible');
            document.body.style.overflow = '';
        }

        toggle?.addEventListener('click', () =>
            sidebar?.classList.contains('open') ? closeSidebar() : openSidebar()
        );

        overlay?.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeSidebar();
        });
    </script>

    @stack('scripts')
</body>

</html>