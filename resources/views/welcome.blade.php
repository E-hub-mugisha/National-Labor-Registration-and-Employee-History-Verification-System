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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════════════════════ */
        :root {
            --navy: #0b1f3a;
            --navy-mid: #132d52;
            --navy-light: #1a3d6e;
            --gold: #c4922a;
            --gold-light: #e8b84b;
            --gold-pale: #fdf3e0;
            --cream: #fafaf7;
            --slate: #4a5f7a;
            --border-soft: rgba(196, 146, 42, .2);
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'DM Sans', system-ui, sans-serif;
        }

        /* ═══════════════════════════════════════════════════════════
   RESET / GLOBAL
═══════════════════════════════════════════════════════════ */
        .welcome-page * {
            box-sizing: border-box;
        }

        .welcome-page {
            font-family: var(--font-body);
            color: var(--navy);
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════════════════════════
   TOPNAV
═══════════════════════════════════════════════════════════ */
        .w-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1.1rem 0;
            background: transparent;
            transition: background .35s, padding .35s, box-shadow .35s;
        }

        .w-nav.scrolled {
            background: rgba(11, 31, 58, .97);
            backdrop-filter: blur(12px);
            padding: .7rem 0;
            box-shadow: 0 1px 24px rgba(0, 0, 0, .3);
        }

        .w-nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .w-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
        }

        .w-logo-mark {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--navy);
            flex-shrink: 0;
        }

        .w-logo-text {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.1;
        }

        .w-logo-text small {
            display: block;
            font-size: .65rem;
            font-weight: 400;
            letter-spacing: .12em;
            color: var(--gold-light);
            text-transform: uppercase;
        }

        .w-nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .w-nav-links a {
            color: rgba(255, 255, 255, .75);
            text-decoration: none;
            font-size: .85rem;
            font-weight: 500;
            letter-spacing: .02em;
            transition: color .2s;
        }

        .w-nav-links a:hover {
            color: var(--gold-light);
        }

        .w-nav-cta {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .btn-nav-login {
            color: rgba(255, 255, 255, .85) !important;
            text-decoration: none;
            font-size: .85rem;
            font-weight: 500;
            padding: .45rem .9rem;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 6px;
            transition: all .2s;
        }

        .btn-nav-login:hover {
            border-color: var(--gold-light);
            color: var(--gold-light) !important;
        }

        .btn-nav-register {
            background: var(--gold);
            color: var(--navy) !important;
            text-decoration: none;
            font-size: .85rem;
            font-weight: 700;
            padding: .45rem 1.1rem;
            border-radius: 6px;
            transition: background .2s, box-shadow .2s;
        }

        .btn-nav-register:hover {
            background: var(--gold-light);
            box-shadow: 0 4px 16px rgba(196, 146, 42, .35);
        }

        /* ═══════════════════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════════════════ */
        .hero {
            min-height: 100vh;
            background: var(--navy);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Geometric background pattern */
        .hero-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(196, 146, 42, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(196, 146, 42, .06) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .hero-glow-1 {
            position: absolute;
            top: -20%;
            right: -10%;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(196, 146, 42, .12) 0%, transparent 70%);
        }

        .hero-glow-2 {
            position: absolute;
            bottom: -10%;
            left: -5%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(26, 61, 110, .6) 0%, transparent 70%);
        }

        .hero-stripe {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 45%;
            background: linear-gradient(135deg, rgba(26, 61, 110, .4) 0%, rgba(11, 31, 58, 0) 100%);
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0 100%);
        }

        /* Rwanda flag accent bar */
        .hero-flag-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #20603d 0%, #20603d 33%, #e5be01 33%, #e5be01 66%, #169cda 66%, #169cda 100%);
        }

        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 8rem 2rem 6rem;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        @media (max-width: 900px) {
            .hero-inner {
                grid-template-columns: 1fr;
                gap: 3rem;
                padding: 7rem 1.5rem 4rem;
            }

            .hero-right {
                display: none;
            }
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(196, 146, 42, .12);
            border: 1px solid var(--border-soft);
            color: var(--gold-light);
            border-radius: 20px;
            padding: .3rem .9rem;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .hero-eyebrow svg {
            width: 12px;
            height: 12px;
        }

        .hero-h1 {
            font-family: var(--font-display);
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
            margin: 0 0 1.25rem;
        }

        .hero-h1 em {
            color: var(--gold-light);
            font-style: italic;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, .65);
            line-height: 1.7;
            margin: 0 0 2.5rem;
            font-weight: 300;
            max-width: 480px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--gold);
            color: var(--navy);
            font-weight: 700;
            font-size: .9rem;
            text-decoration: none;
            padding: .8rem 1.75rem;
            border-radius: 8px;
            transition: all .2s;
            letter-spacing: .01em;
        }

        .btn-hero-primary:hover {
            background: var(--gold-light);
            color: var(--navy);
            box-shadow: 0 6px 24px rgba(196, 146, 42, .4);
            transform: translateY(-1px);
        }

        .btn-hero-primary svg {
            width: 16px;
            height: 16px;
        }

        .btn-hero-outline {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: rgba(255, 255, 255, .8);
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            padding: .8rem 1.5rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, .2);
            transition: all .2s;
        }

        .btn-hero-outline:hover {
            border-color: rgba(255, 255, 255, .5);
            color: #fff;
            background: rgba(255, 255, 255, .05);
        }

        .btn-hero-outline svg {
            width: 16px;
            height: 16px;
        }

        /* Hero right — dashboard mockup */
        .hero-right {
            position: relative;
        }

        .hero-card {
            background: rgba(19, 45, 82, .8);
            border: 1px solid rgba(196, 146, 42, .2);
            border-radius: 14px;
            padding: 1.5rem;
            backdrop-filter: blur(8px);
            box-shadow: 0 24px 80px rgba(0, 0, 0, .4), 0 0 0 1px rgba(196, 146, 42, .1);
        }

        .hc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .hc-title {
            font-size: .8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .9);
        }

        .hc-badge {
            background: rgba(196, 146, 42, .15);
            border: 1px solid rgba(196, 146, 42, .3);
            color: var(--gold-light);
            font-size: .65rem;
            font-weight: 700;
            padding: .15rem .5rem;
            border-radius: 4px;
            letter-spacing: .05em;
        }

        .hc-stat-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .75rem;
            margin-bottom: 1.25rem;
        }

        .hc-stat {
            background: rgba(255, 255, 255, .04);
            border-radius: 8px;
            padding: .75rem;
            border: 1px solid rgba(255, 255, 255, .06);
        }

        .hc-stat-val {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gold-light);
            line-height: 1;
        }

        .hc-stat-lbl {
            font-size: .62rem;
            color: rgba(255, 255, 255, .4);
            margin-top: .25rem;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .hc-list {
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        .hc-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            background: rgba(255, 255, 255, .03);
            border-radius: 8px;
            padding: .65rem .85rem;
            border: 1px solid rgba(255, 255, 255, .06);
            transition: border-color .2s;
        }

        .hc-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .65rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .hc-emp-name {
            font-size: .78rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .9);
        }

        .hc-emp-role {
            font-size: .65rem;
            color: rgba(255, 255, 255, .4);
            margin-top: .05rem;
        }

        .hc-emp-badge {
            margin-left: auto;
            font-size: .62rem;
            font-weight: 600;
            padding: .15rem .45rem;
            border-radius: 4px;
        }

        .badge-active-sm {
            background: rgba(25, 135, 84, .2);
            color: #75e0a7;
        }

        .badge-pending-sm {
            background: rgba(255, 193, 7, .15);
            color: #ffc107;
        }

        /* floating accent cards */
        .hero-float-1 {
            position: absolute;
            top: -24px;
            right: -24px;
            background: var(--gold);
            border-radius: 10px;
            padding: .75rem 1rem;
            color: var(--navy);
            font-weight: 700;
            font-size: .8rem;
            box-shadow: 0 8px 32px rgba(196, 146, 42, .4);
            white-space: nowrap;
        }

        .hero-float-2 {
            position: absolute;
            bottom: -20px;
            left: -20px;
            background: rgba(19, 45, 82, .95);
            border: 1px solid rgba(196, 146, 42, .3);
            border-radius: 10px;
            padding: .75rem 1rem;
            color: #fff;
            font-size: .78rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .3);
            white-space: nowrap;
        }

        /* ═══════════════════════════════════════════════════════════
   STATS STRIP
═══════════════════════════════════════════════════════════ */
        .stats-strip {
            background: var(--gold);
            padding: 2.5rem 0;
        }

        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(0, 0, 0, .1);
        }

        @media (max-width: 700px) {
            .stats-inner {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-item {
            background: var(--gold);
            padding: .5rem 2rem;
            text-align: center;
        }

        .stat-num {
            font-family: var(--font-display);
            font-size: 2.75rem;
            font-weight: 700;
            color: var(--navy);
            line-height: 1;
        }

        .stat-label {
            font-size: .78rem;
            color: rgba(11, 31, 58, .65);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: .3rem;
        }

        /* ═══════════════════════════════════════════════════════════
   WHO IS IT FOR
═══════════════════════════════════════════════════════════ */
        .roles-section {
            padding: 6rem 0;
            background: var(--cream);
        }

        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-eyebrow {
            display: inline-block;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--gold);
            margin-bottom: .75rem;
        }

        .section-heading {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
            font-weight: 700;
            color: var(--navy);
            line-height: 1.2;
            margin: 0 0 1rem;
        }

        .section-heading em {
            color: var(--gold);
            font-style: italic;
        }

        .section-sub {
            font-size: .95rem;
            color: var(--slate);
            line-height: 1.7;
            max-width: 520px;
            margin: 0;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3.5rem;
        }

        @media (max-width: 768px) {
            .roles-grid {
                grid-template-columns: 1fr;
            }
        }

        .role-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e8e8e8;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s, border-color .25s;
        }

        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(11, 31, 58, .1);
            border-color: var(--gold);
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .role-card.employer::before {
            background: #0d6efd;
        }

        .role-card.employee::before {
            background: #198754;
        }

        .role-card.government::before {
            background: var(--gold);
        }

        .role-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .role-icon.employer {
            background: #e8f0fe;
        }

        .role-icon.employee {
            background: #e8f5ee;
        }

        .role-icon.government {
            background: var(--gold-pale);
        }

        .role-title {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--navy);
            margin: 0 0 .6rem;
        }

        .role-desc {
            font-size: .85rem;
            color: var(--slate);
            line-height: 1.65;
            margin: 0 0 1.5rem;
        }

        .role-features {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .role-features li {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            font-size: .82rem;
            color: var(--slate);
            line-height: 1.4;
        }

        .role-features li::before {
            content: '✓';
            color: var(--gold);
            font-weight: 700;
            flex-shrink: 0;
            margin-top: .05rem;
        }

        .role-cta {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            margin-top: 1.5rem;
            padding: .5rem 0;
            border-bottom: 2px solid transparent;
            transition: border-color .2s, gap .2s;
        }

        .role-cta.employer {
            color: #0d6efd;
        }

        .role-cta.employee {
            color: #198754;
        }

        .role-cta.government {
            color: var(--gold);
        }

        .role-cta:hover {
            border-bottom-color: currentColor;
            gap: .65rem;
        }

        .role-cta svg {
            width: 14px;
            height: 14px;
        }

        /* ═══════════════════════════════════════════════════════════
   HOW IT WORKS
═══════════════════════════════════════════════════════════ */
        .how-section {
            padding: 6rem 0;
            background: var(--navy);
            position: relative;
            overflow: hidden;
        }

        .how-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(196, 146, 42, .05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(196, 146, 42, .05) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .how-inner {
            position: relative;
            z-index: 1;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-top: 3.5rem;
            position: relative;
        }

        @media (max-width: 900px) {
            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }
        }

        /* connecting line */
        .steps-grid::before {
            content: '';
            position: absolute;
            top: 28px;
            left: calc(12.5% + 1rem);
            right: calc(12.5% + 1rem);
            height: 1px;
            background: linear-gradient(90deg, var(--gold) 0%, rgba(196, 146, 42, .2) 100%);
            pointer-events: none;
        }

        @media (max-width: 900px) {
            .steps-grid::before {
                display: none;
            }
        }

        .step-item {
            text-align: center;
        }

        .step-num {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(196, 146, 42, .12);
            border: 2px solid var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--gold-light);
            margin: 0 auto 1.25rem;
            position: relative;
            z-index: 1;
        }

        .step-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 600;
            color: #fff;
            margin: 0 0 .6rem;
        }

        .step-desc {
            font-size: .82rem;
            color: rgba(255, 255, 255, .5);
            line-height: 1.65;
        }

        /* ═══════════════════════════════════════════════════════════
   FEATURES
═══════════════════════════════════════════════════════════ */
        .features-section {
            padding: 6rem 0;
            background: #fff;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3.5rem;
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        .feature-card {
            padding: 1.75rem;
            border-radius: 12px;
            background: var(--cream);
            border: 1px solid #ebebeb;
            transition: border-color .2s, box-shadow .2s;
        }

        .feature-card:hover {
            border-color: var(--gold);
            box-shadow: 0 8px 32px rgba(196, 146, 42, .1);
        }

        .feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .feature-icon svg {
            width: 22px;
            height: 22px;
            color: var(--gold-light);
        }

        .feature-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--navy);
            margin: 0 0 .5rem;
        }

        .feature-desc {
            font-size: .83rem;
            color: var(--slate);
            line-height: 1.65;
            margin: 0;
        }

        /* ═══════════════════════════════════════════════════════════
   TESTIMONIAL / TRUST
═══════════════════════════════════════════════════════════ */
        .trust-section {
            padding: 5rem 0;
            background: var(--gold-pale);
            border-top: 1px solid rgba(196, 146, 42, .2);
            border-bottom: 1px solid rgba(196, 146, 42, .2);
        }

        .trust-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .trust-grid {
                grid-template-columns: 1fr;
            }
        }

        .trust-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.75rem;
            border: 1px solid rgba(196, 146, 42, .2);
            position: relative;
        }

        .trust-card::before {
            content: '"';
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-family: var(--font-display);
            font-size: 4rem;
            line-height: 1;
            color: var(--gold);
            opacity: .3;
        }

        .trust-text {
            font-size: .88rem;
            color: var(--slate);
            line-height: 1.7;
            margin: 0 0 1.25rem;
            font-style: italic;
        }

        .trust-author {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .trust-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--navy);
            color: var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            font-family: var(--font-display);
            flex-shrink: 0;
        }

        .trust-name {
            font-weight: 600;
            font-size: .82rem;
            color: var(--navy);
        }

        .trust-role {
            font-size: .72rem;
            color: var(--slate);
            margin-top: .1rem;
        }

        /* ═══════════════════════════════════════════════════════════
   CTA SECTION
═══════════════════════════════════════════════════════════ */
        .cta-section {
            padding: 6rem 0;
            background: var(--navy);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 80% at 50% 50%, rgba(196, 146, 42, .1) 0%, transparent 70%);
        }

        .cta-inner {
            position: relative;
            z-index: 1;
            max-width: 640px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .cta-heading {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: #fff;
            margin: 0 0 1rem;
            line-height: 1.15;
        }

        .cta-heading em {
            color: var(--gold-light);
            font-style: italic;
        }

        .cta-sub {
            color: rgba(255, 255, 255, .55);
            font-size: .95rem;
            line-height: 1.7;
            margin: 0 0 2.5rem;
        }

        .cta-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* ═══════════════════════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════════════════════ */
        .w-footer {
            background: #080f1e;
            padding: 3.5rem 0 2rem;
            color: rgba(255, 255, 255, .45);
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .footer-top {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 500px) {
            .footer-top {
                grid-template-columns: 1fr;
            }
        }

        .footer-brand p {
            font-size: .82rem;
            line-height: 1.7;
            margin: .75rem 0 0;
            max-width: 260px;
        }

        .footer-col-title {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: rgba(255, 255, 255, .6);
            margin: 0 0 1rem;
        }

        .footer-col-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: .5rem;
        }

        .footer-col-links a {
            color: rgba(255, 255, 255, .4);
            text-decoration: none;
            font-size: .82rem;
            transition: color .2s;
        }

        .footer-col-links a:hover {
            color: var(--gold-light);
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: .75rem;
        }

        .footer-bottom a {
            color: rgba(255, 255, 255, .35);
            text-decoration: none;
        }

        .footer-bottom a:hover {
            color: var(--gold-light);
        }

        .footer-flag {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .flag-bar {
            display: flex;
            border-radius: 3px;
            overflow: hidden;
            height: 10px;
            width: 30px;
        }

        .flag-bar span:nth-child(1) {
            flex: 1;
            background: #169cda;
        }

        .flag-bar span:nth-child(2) {
            flex: 1;
            background: #e5be01;
        }

        .flag-bar span:nth-child(3) {
            flex: 1;
            background: #20603d;
        }

        /* ═══════════════════════════════════════════════════════════
   ANIMATIONS
═══════════════════════════════════════════════════════════ */
        .fade-up {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: none;
        }

        .fade-up.d1 {
            transition-delay: .1s;
        }

        .fade-up.d2 {
            transition-delay: .2s;
        }

        .fade-up.d3 {
            transition-delay: .3s;
        }

        .fade-up.d4 {
            transition-delay: .4s;
        }

        @@keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .hero-card-wrap {
            animation: float 5s ease-in-out infinite;
        }
    </style>
</head>

<body>
    <div class="welcome-page">

        {{-- ══════════════════════════════════════════════
         NAV
    ══════════════════════════════════════════════ --}}
        <nav class="w-nav" id="wNav">
            <div class="w-nav-inner">
                <a href="{{ route('home') }}" class="w-logo">
                    <div class="w-logo-mark">ER</div>
                    <div class="w-logo-text">
                        EmpRecord
                        <small>Rwanda</small>
                    </div>
                </a>
                <div class="w-nav-links d-none d-md-flex">
                    <a href="#roles">Who It's For</a>
                    <a href="#how">How It Works</a>
                    <a href="#features">Features</a>
                </div>
                <div class="w-nav-cta">
                    <a href="{{ route('login') }}" class="btn-nav-login">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-nav-register">Get Started</a>
                </div>
            </div>
        </nav>

        {{-- ══════════════════════════════════════════════
         HERO
    ══════════════════════════════════════════════ --}}
        <section class="hero">
            <div class="hero-bg">
                <div class="hero-grid"></div>
                <div class="hero-glow-1"></div>
                <div class="hero-glow-2"></div>
                <div class="hero-stripe"></div>
                <div class="hero-flag-accent"></div>
            </div>

            <div class="hero-inner">
                {{-- Left --}}
                <div class="hero-left">
                    <div class="hero-eyebrow">
                        <svg viewBox="0 0 12 12" fill="currentColor">
                            <circle cx="6" cy="6" r="6" />
                        </svg>
                        Official Employment Records Platform
                    </div>
                    <h1 class="hero-h1">
                        Rwanda's Trusted<br>
                        <em>Employment Record</em><br>
                        Management System
                    </h1>
                    <p class="hero-sub">
                        A centralised platform connecting employers, employees, and government agencies
                        to maintain accurate, verified employment histories across Rwanda.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('register') }}" class="btn-hero-primary">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Create Account
                        </a>
                        <a href="#how" class="btn-hero-outline">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            See How It Works
                        </a>
                    </div>
                </div>

                {{-- Right — dashboard card --}}
                <div class="hero-right">
                    <div class="hero-card-wrap">
                        <div style="position:relative">
                            <div class="hero-float-1">✓ 12,400+ Records Verified</div>
                            <div class="hero-card">
                                <div class="hc-header">
                                    <span class="hc-title">Employer Dashboard</span>
                                    <span class="hc-badge">LIVE</span>
                                </div>
                                <div class="hc-stat-row">
                                    <div class="hc-stat">
                                        <div class="hc-stat-val">48</div>
                                        <div class="hc-stat-lbl">Employees</div>
                                    </div>
                                    <div class="hc-stat">
                                        <div class="hc-stat-val">12</div>
                                        <div class="hc-stat-lbl">Records</div>
                                    </div>
                                    <div class="hc-stat">
                                        <div class="hc-stat-val">3</div>
                                        <div class="hc-stat-lbl">Pending</div>
                                    </div>
                                </div>
                                <div class="hc-list">
                                    <div class="hc-item">
                                        <div class="hc-avatar" style="background:rgba(13,110,253,.15);color:#60a5fa">JM</div>
                                        <div>
                                            <div class="hc-emp-name">Jean-Marie Nkusi</div>
                                            <div class="hc-emp-role">Senior Developer · IT</div>
                                        </div>
                                        <span class="hc-emp-badge badge-active-sm">Active</span>
                                    </div>
                                    <div class="hc-item">
                                        <div class="hc-avatar" style="background:rgba(25,135,84,.15);color:#6ee7a0">AM</div>
                                        <div>
                                            <div class="hc-emp-name">Amina Mukamana</div>
                                            <div class="hc-emp-role">Finance Officer · Accounts</div>
                                        </div>
                                        <span class="hc-emp-badge badge-active-sm">Active</span>
                                    </div>
                                    <div class="hc-item">
                                        <div class="hc-avatar" style="background:rgba(255,193,7,.15);color:#fbbf24">PH</div>
                                        <div>
                                            <div class="hc-emp-name">Patrick Habimana</div>
                                            <div class="hc-emp-role">HR Manager · Human Resources</div>
                                        </div>
                                        <span class="hc-emp-badge badge-pending-sm">Pending</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-float-2">🔒 End-to-end verified records</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════════
         STATS STRIP
    ══════════════════════════════════════════════ --}}
        <div class="stats-strip">
            <div class="stats-inner">
                <div class="stat-item fade-up">
                    <div class="stat-num">2,400+</div>
                    <div class="stat-label">Registered Employers</div>
                </div>
                <div class="stat-item fade-up d1">
                    <div class="stat-num">86K+</div>
                    <div class="stat-label">Employment Records</div>
                </div>
                <div class="stat-item fade-up d2">
                    <div class="stat-num">5</div>
                    <div class="stat-label">Provinces Covered</div>
                </div>
                <div class="stat-item fade-up d3">
                    <div class="stat-num">99.2%</div>
                    <div class="stat-label">Verification Accuracy</div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
         WHO IS IT FOR
    ══════════════════════════════════════════════ --}}
        <section class="roles-section" id="roles">
            <div class="section-inner">
                <div class="fade-up">
                    <span class="section-eyebrow">Who It Serves</span>
                    <h2 class="section-heading">Built for <em>Every Stakeholder</em><br>in the Employment Ecosystem</h2>
                    <p class="section-sub">
                        Whether you're an organisation managing staff, an individual tracking your career,
                        or a government body overseeing labour policy — this platform is built for you.
                    </p>
                </div>

                <div class="roles-grid">
                    {{-- Employer --}}
                    <div class="role-card employer fade-up d1">
                        <div class="role-icon employer">🏢</div>
                        <div class="role-title">Employers</div>
                        <p class="role-desc">
                            Companies and organisations can manage their workforce records,
                            issue conduct ratings, and report employment changes in real time.
                        </p>
                        <ul class="role-features">
                            <li>Add &amp; manage employment records</li>
                            <li>Issue conduct ratings &amp; exit reports</li>
                            <li>Verify new hire backgrounds</li>
                            <li>Submit transfer requests</li>
                            <li>Generate workforce analytics</li>
                        </ul>
                        <a href="{{ route('register') }}" class="role-cta employer">
                            Register as Employer
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>

                    {{-- Employee --}}
                    <div class="role-card employee fade-up d2">
                        <div class="role-icon employee">👤</div>
                        <div class="role-title">Employees</div>
                        <p class="role-desc">
                            Workers can view their complete employment history, accept or dispute
                            records, and present verified credentials to prospective employers.
                        </p>
                        <ul class="role-features">
                            <li>View your full employment history</li>
                            <li>Accept or dispute records</li>
                            <li>Share verified credentials</li>
                            <li>Track salary &amp; position changes</li>
                            <li>File claims when needed</li>
                        </ul>
                        <a href="{{ route('login') }}" class="role-cta employee">
                            Access Your Records
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>

                    {{-- Government --}}
                    <div class="role-card government fade-up d3">
                        <div class="role-icon government">🏛️</div>
                        <div class="role-title">Government</div>
                        <p class="role-desc">
                            Ministry officials and regulatory bodies gain a real-time view of
                            national employment data, enabling policy decisions backed by accurate data.
                        </p>
                        <ul class="role-features">
                            <li>Verify &amp; approve employer accounts</li>
                            <li>Monitor employment transfers</li>
                            <li>Review &amp; resolve claims</li>
                            <li>Access national labour statistics</li>
                            <li>Audit employer compliance</li>
                        </ul>
                        <a href="{{ route('register') }}" class="role-cta government">
                            Register as Official
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════════
         HOW IT WORKS
    ══════════════════════════════════════════════ --}}
        <section class="how-section" id="how">
            <div class="section-inner how-inner">
                <div class="fade-up" style="color:#fff">
                    <span class="section-eyebrow">The Process</span>
                    <h2 class="section-heading" style="color:#fff">Simple Steps to <em>Verified Records</em></h2>
                    <p class="section-sub" style="color:rgba(255,255,255,.5)">
                        From registration to verified employment history — the entire workflow in four clear steps.
                    </p>
                </div>

                <div class="steps-grid">
                    <div class="step-item fade-up d1">
                        <div class="step-num">1</div>
                        <div class="step-title">Register &amp; Verify</div>
                        <p class="step-desc">Employers register with their TIN number. Government officials verify company credentials through RRA and RDB integration.</p>
                    </div>
                    <div class="step-item fade-up d2">
                        <div class="step-num">2</div>
                        <div class="step-title">Add Employees</div>
                        <p class="step-desc">Verified employers search for employees by national ID and link them to the organisation with a formal employment record.</p>
                    </div>
                    <div class="step-item fade-up d3">
                        <div class="step-num">3</div>
                        <div class="step-title">Manage Records</div>
                        <p class="step-desc">Update positions, salaries, and departments in real time. Log exits with conduct ratings and official reasons when employment ends.</p>
                    </div>
                    <div class="step-item fade-up d4">
                        <div class="step-num">4</div>
                        <div class="step-title">Verified History</div>
                        <p class="step-desc">Employees receive a tamper-proof employment history that can be shared with future employers or government agencies at any time.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════════
         FEATURES
    ══════════════════════════════════════════════ --}}
        <section class="features-section" id="features">
            <div class="section-inner">
                <div class="fade-up">
                    <span class="section-eyebrow">Platform Features</span>
                    <h2 class="section-heading">Everything You Need to <em>Manage</em><br>Employment Records</h2>
                </div>

                <div class="features-grid">
                    <div class="feature-card fade-up d1">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <div class="feature-title">TIN-Verified Employers</div>
                        <p class="feature-desc">Every employer is cross-checked with Rwanda Revenue Authority before being allowed to create or modify employment records.</p>
                    </div>

                    <div class="feature-card fade-up d2">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div class="feature-title">Complete Employment History</div>
                        <p class="feature-desc">Track every position, salary change, department transfer, and exit reason — with timestamps and conduct ratings for every record.</p>
                    </div>

                    <div class="feature-card fade-up d3">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                            </svg>
                        </div>
                        <div class="feature-title">Government Analytics</div>
                        <p class="feature-desc">Real-time dashboards give ministries a national view of employment trends, sector distribution, and compliance status across all provinces.</p>
                    </div>

                    <div class="feature-card fade-up d1">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                            </svg>
                        </div>
                        <div class="feature-title">Transfer Management</div>
                        <p class="feature-desc">Structured inter-employer transfer requests ensure continuity of service records when employees move between organisations.</p>
                    </div>

                    <div class="feature-card fade-up d2">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="feature-title">Dispute &amp; Claims</div>
                        <p class="feature-desc">Employees can accept or dispute records. A structured claims process with government oversight ensures fair resolution for all parties.</p>
                    </div>

                    <div class="feature-card fade-up d3">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div class="feature-title">Instant Notifications</div>
                        <p class="feature-desc">Email alerts keep all parties informed — when records are added, disputes are raised, or accounts are approved — with no manual follow-up required.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════════
         TRUST / TESTIMONIALS
    ══════════════════════════════════════════════ --}}
        <section class="trust-section">
            <div class="section-inner">
                <div class="fade-up" style="text-align:center">
                    <span class="section-eyebrow">Trusted Across Rwanda</span>
                    <h2 class="section-heading" style="max-width:500px;margin:0 auto">
                        What Our <em>Users Say</em>
                    </h2>
                </div>

                <div class="trust-grid">
                    <div class="trust-card fade-up d1">
                        <p class="trust-text">
                            The verification process that used to take weeks now takes minutes.
                            Our HR team can instantly confirm a candidate's employment history before making an offer.
                        </p>
                        <div class="trust-author">
                            <div class="trust-avatar">RK</div>
                            <div>
                                <div class="trust-name">Rwanda Kanda</div>
                                <div class="trust-role">HR Director · Kigali Technology Ltd</div>
                            </div>
                        </div>
                    </div>

                    <div class="trust-card fade-up d2">
                        <p class="trust-text">
                            As a government official, having a single source of truth for employment data
                            across all sectors has fundamentally improved how we develop labour policy.
                        </p>
                        <div class="trust-author">
                            <div class="trust-avatar">PM</div>
                            <div>
                                <div class="trust-name">Pascal Mugisha</div>
                                <div class="trust-role">Labour Inspector · Ministry of Public Service</div>
                            </div>
                        </div>
                    </div>

                    <div class="trust-card fade-up d3">
                        <p class="trust-text">
                            I was able to access my full employment history and share it with my new employer
                            on the same day. No paperwork, no waiting for reference letters.
                        </p>
                        <div class="trust-author">
                            <div class="trust-avatar">AN</div>
                            <div>
                                <div class="trust-name">Alice Nyirahabimana</div>
                                <div class="trust-role">Accountant · Kigali</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════════
         CTA
    ══════════════════════════════════════════════ --}}
        <section class="cta-section">
            <div class="cta-inner">
                <div class="fade-up">
                    <h2 class="cta-heading">
                        Ready to Bring Your<br>
                        Records <em>Into the Future?</em>
                    </h2>
                    <p class="cta-sub">
                        Join thousands of employers and employees already using Rwanda's official
                        employment records platform. Registration is free and takes under five minutes.
                    </p>
                    <div class="cta-actions">
                        <a href="{{ route('register') }}" class="btn-hero-primary">
                            <svg viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="btn-hero-outline">
                            Sign In to Existing Account
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════════ --}}
        <footer class="w-footer">
            <div class="footer-inner">
                <div class="footer-top">
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="w-logo">
                            <div class="w-logo-mark">ER</div>
                            <div class="w-logo-text">
                                EmpRecord
                                <small>Rwanda</small>
                            </div>
                        </a>
                        <p>Rwanda's centralised employment records management system, connecting employers, employees, and government agencies.</p>
                    </div>
                    <div>
                        <div class="footer-col-title">Platform</div>
                        <ul class="footer-col-links">
                            <li><a href="#roles">Who It's For</a></li>
                            <li><a href="#how">How It Works</a></li>
                            <li><a href="#features">Features</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="footer-col-title">Portals</div>
                        <ul class="footer-col-links">
                            <li><a href="{{ route('employer.register') }}">Employer Portal</a></li>
                            <li><a href="{{ route('employee.dashboard') }}">Employee Portal</a></li>
                            <li><a href="{{ route('gov.dashboard') }}">Government Portal</a></li>
                            <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="footer-col-title">Support</div>
                        <ul class="footer-col-links">
                            <li><a href="mailto:{{ config('mail.from.address') }}">Contact Us</a></li>
                            <li><a href="#">Help Centre</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-bottom">
                    <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
                    <div class="footer-flag">
                        <span style="font-size:.72rem">Made in</span>
                        <div class="flag-bar">
                            <span></span><span></span><span></span>
                        </div>
                        <span style="font-size:.72rem">Rwanda</span>
                    </div>
                    <a href="{{ route('login') }}">Sign In</a>
                </div>
            </div>
        </footer>

    </div>{{-- /welcome-page --}}

    <script>
        // ── Sticky nav ────────────────────────────────────────────
        const nav = document.getElementById('wNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 60);
        }, {
            passive: true
        });

        // ── Scroll-triggered fade-up ──────────────────────────────
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    observer.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.12
        });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

        // ── Smooth scroll for anchor links ────────────────────────
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // ── Counter animation for stats ───────────────────────────
        function animateCounter(el) {
            const text = el.textContent.trim();
            const num = parseFloat(text.replace(/[^0-9.]/g, ''));
            const suffix = text.replace(/[0-9.,]/g, '');
            let start = 0;
            const dur = 1800;
            const step = 16;
            const inc = num / (dur / step);

            const timer = setInterval(() => {
                start = Math.min(start + inc, num);
                el.textContent = (start >= 1000 ? (start / 1000).toFixed(1) + 'K' : Math.floor(start)) + suffix.replace(/K/, '');
                if (start >= num) {
                    el.textContent = text; // restore original
                    clearInterval(timer);
                }
            }, step);
        }

        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.querySelectorAll('.stat-num').forEach(animateCounter);
                    statObserver.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.5
        });

        document.querySelector('.stats-strip') && statObserver.observe(document.querySelector('.stats-strip'));
    </script>

</body>

</html>