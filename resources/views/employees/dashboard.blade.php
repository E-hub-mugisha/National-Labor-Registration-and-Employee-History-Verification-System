{{-- employees/dashboard.blade.php --}}
@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<style>
    :root {
        --ink:        #0d0e12;
        --ink-2:      #1c1e27;
        --ink-3:      #2e3140;
        --surface:    #f4f3ef;
        --surface-2:  #eceae3;
        --surface-3:  #e0ddd4;
        --gold:       #c9a84c;
        --gold-light: #e8ca7a;
        --gold-dim:   rgba(201,168,76,.15);
        --emerald:    #2d7a5f;
        --emerald-dim:rgba(45,122,95,.12);
        --rose:       #b5454b;
        --rose-dim:   rgba(181,69,75,.12);
        --sky:        #2c6fa8;
        --sky-dim:    rgba(44,111,168,.12);
        --radius:     10px;
        --shadow-sm:  0 1px 3px rgba(13,14,18,.07), 0 1px 2px rgba(13,14,18,.05);
        --shadow:     0 4px 16px rgba(13,14,18,.09), 0 1px 4px rgba(13,14,18,.06);
        --shadow-lg:  0 12px 40px rgba(13,14,18,.12), 0 4px 12px rgba(13,14,18,.08);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--surface);
        color: var(--ink);
        font-size: 15px;
        line-height: 1.55;
        -webkit-font-smoothing: antialiased;
    }

    /* ── Layout ──────────────────────────────────────────────────── */
    .emp-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px 80px;
    }

    /* ── Hero header ─────────────────────────────────────────────── */
    .hero {
        position: relative;
        background: var(--ink);
        border-radius: 0 0 24px 24px;
        padding: 48px 40px 40px;
        margin: 0 -24px 40px;
        overflow: hidden;
        color: #fff;
    }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 85% 20%, rgba(201,168,76,.22) 0%, transparent 65%),
            radial-gradient(ellipse 40% 60% at 10% 90%, rgba(44,111,168,.18) 0%, transparent 60%);
        pointer-events: none;
    }
    .hero-grid {
        position: relative;
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 28px;
    }
    .hero-avatar {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 28px; font-weight: 700;
        color: var(--ink);
        flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(201,168,76,.3);
    }
    .hero-name {
        font-family: 'Syne', sans-serif;
        font-size: 26px; font-weight: 700;
        letter-spacing: -.3px;
        line-height: 1.2;
    }
    .hero-meta {
        display: flex; flex-wrap: wrap; gap: 8px 20px;
        margin-top: 6px;
        font-size: 13.5px;
        color: rgba(255,255,255,.6);
    }
    .hero-meta span { display: flex; align-items: center; gap: 5px; }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 500;
        color: rgba(255,255,255,.75);
        backdrop-filter: blur(6px);
    }
    .hero-badge.active { background: rgba(45,122,95,.25); border-color: rgba(45,122,95,.4); color: #6dd4aa; }
    .hero-badge.pending { background: rgba(201,168,76,.2); border-color: rgba(201,168,76,.35); color: var(--gold-light); }
    .hero-status-col { display: flex; flex-direction: column; gap: 8px; align-items: flex-end; }

    /* ── Section labels ──────────────────────────────────────────── */
    .section-label {
        font-family: 'Syne', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 14px;
        display: flex; align-items: center; gap: 8px;
    }
    .section-label::after {
        content: '';
        flex: 1; height: 1px;
        background: linear-gradient(90deg, var(--surface-3), transparent);
    }

    /* ── Stat cards row ──────────────────────────────────────────── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 36px;
    }
    .stat-card {
        background: #fff;
        border: 1px solid var(--surface-3);
        border-radius: var(--radius);
        padding: 20px 22px;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
    }
    .stat-card:hover { box-shadow: var(--shadow); transform: translateY(-2px); }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--accent, var(--gold));
        border-radius: var(--radius) var(--radius) 0 0;
    }
    .stat-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
        font-size: 16px;
        background: var(--accent-dim, var(--gold-dim));
        color: var(--accent, var(--gold));
    }
    .stat-val {
        font-family: 'Syne', sans-serif;
        font-size: 30px; font-weight: 800;
        letter-spacing: -1px;
        line-height: 1;
        color: var(--ink);
    }
    .stat-label {
        font-size: 12px; font-weight: 500;
        color: #888;
        margin-top: 4px;
        letter-spacing: .01em;
    }

    /* ── Two-col body ────────────────────────────────────────────── */
    .body-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
        align-items: start;
    }

    /* ── Panel ───────────────────────────────────────────────────── */
    .panel {
        background: #fff;
        border: 1px solid var(--surface-3);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .panel-head {
        padding: 18px 22px 0;
    }
    .panel-title {
        font-family: 'Syne', sans-serif;
        font-size: 15px; font-weight: 700;
        color: var(--ink);
    }
    .panel-body { padding: 18px 22px 22px; }

    /* ── Current employer card ───────────────────────────────────── */
    .employer-card {
        display: flex; gap: 16px; align-items: flex-start;
        padding: 18px;
        background: var(--surface);
        border: 1px solid var(--surface-3);
        border-radius: 8px;
        margin-bottom: 14px;
    }
    .employer-logo {
        width: 48px; height: 48px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--gold-dim), var(--surface-3));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 18px;
        color: var(--gold);
        flex-shrink: 0;
        border: 1px solid var(--surface-3);
    }
    .employer-name { font-family: 'Syne', sans-serif; font-weight: 600; font-size: 15px; }
    .employer-pos  { font-size: 13px; color: #777; margin-top: 2px; }
    .employer-dates { font-size: 12px; color: #aaa; margin-top: 3px; }

    /* ── Timeline ────────────────────────────────────────────────── */
    .timeline { position: relative; padding-left: 24px; }
    .timeline::before {
        content: '';
        position: absolute;
        left: 7px; top: 6px; bottom: 6px;
        width: 2px;
        background: var(--surface-3);
        border-radius: 2px;
    }
    .tl-item {
        position: relative;
        padding: 0 0 22px 16px;
    }
    .tl-item:last-child { padding-bottom: 0; }
    .tl-dot {
        position: absolute;
        left: -17px; top: 5px;
        width: 12px; height: 12px;
        border-radius: 50%;
        border: 2px solid var(--surface-3);
        background: #fff;
    }
    .tl-dot.active { background: var(--emerald); border-color: var(--emerald); box-shadow: 0 0 0 3px var(--emerald-dim); }
    .tl-employer { font-weight: 600; font-size: 14px; }
    .tl-pos       { font-size: 13px; color: #666; }
    .tl-period    { font-size: 12px; color: #aaa; margin-top: 2px; display: flex; align-items: center; gap: 6px; }
    .tl-duration  { background: var(--surface-2); border-radius: 4px; padding: 1px 7px; font-size: 11px; color: #888; }
    .conduct-tag  {
        display: inline-flex; align-items: center;
        font-size: 11px; font-weight: 500;
        padding: 2px 8px; border-radius: 999px;
        margin-top: 5px;
    }
    .conduct-tag.excellent  { background: var(--emerald-dim); color: var(--emerald); }
    .conduct-tag.good       { background: var(--sky-dim);     color: var(--sky);     }
    .conduct-tag.average    { background: var(--gold-dim);    color: #a07a20;        }
    .conduct-tag.poor       { background: var(--rose-dim);    color: var(--rose);    }

    /* ── Claims ──────────────────────────────────────────────────── */
    .claim-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--surface-2);
    }
    .claim-row:last-child { border-bottom: none; padding-bottom: 0; }
    .claim-icon {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .claim-icon.pending  { background: var(--gold-dim);    color: #a07a20; }
    .claim-icon.resolved { background: var(--emerald-dim); color: var(--emerald); }
    .claim-icon.rejected { background: var(--rose-dim);    color: var(--rose); }
    .claim-employer { font-size: 12px; color: #999; }
    .claim-title    { font-size: 14px; font-weight: 500; }
    .claim-status   {
        margin-left: auto;
        font-size: 11px; font-weight: 600;
        padding: 3px 9px; border-radius: 999px;
        flex-shrink: 0;
    }
    .claim-status.pending  { background: var(--gold-dim);    color: #a07a20; }
    .claim-status.resolved { background: var(--emerald-dim); color: var(--emerald); }
    .claim-status.rejected { background: var(--rose-dim);    color: var(--rose); }

    /* ── Skills pills ────────────────────────────────────────────── */
    .skills-wrap { display: flex; flex-wrap: wrap; gap: 8px; }
    .skill-pill {
        background: var(--surface);
        border: 1px solid var(--surface-3);
        border-radius: 999px;
        padding: 5px 13px;
        font-size: 13px;
        color: var(--ink-3);
        font-weight: 500;
        transition: background .15s, border-color .15s;
    }
    .skill-pill:hover { background: var(--gold-dim); border-color: var(--gold); color: var(--ink); }

    /* ── Conduct bar chart ───────────────────────────────────────── */
    .conduct-bars { display: flex; flex-direction: column; gap: 10px; }
    .conduct-bar-row { display: flex; align-items: center; gap: 10px; font-size: 13px; }
    .conduct-bar-label { width: 72px; color: #777; flex-shrink: 0; text-transform: capitalize; }
    .conduct-bar-track {
        flex: 1; height: 8px;
        background: var(--surface-2);
        border-radius: 999px;
        overflow: hidden;
    }
    .conduct-bar-fill {
        height: 100%;
        border-radius: 999px;
        transition: width .8s cubic-bezier(.4,0,.2,1);
    }
    .conduct-bar-fill.excellent { background: var(--emerald); }
    .conduct-bar-fill.good      { background: var(--sky);     }
    .conduct-bar-fill.average   { background: var(--gold);    }
    .conduct-bar-fill.poor      { background: var(--rose);    }
    .conduct-bar-count { font-weight: 600; font-size: 13px; color: var(--ink); min-width: 16px; text-align: right; }

    /* ── Transfer banner ─────────────────────────────────────────── */
    .transfer-banner {
        display: flex; align-items: flex-start; gap: 12px;
        background: var(--gold-dim);
        border: 1px solid rgba(201,168,76,.3);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }
    .transfer-icon { font-size: 20px; margin-top: 1px; }
    .transfer-label { font-size: 13px; font-weight: 600; color: #7a5c1a; }
    .transfer-sub   { font-size: 12px; color: #a07a20; margin-top: 2px; }

    /* ── Empty states ────────────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 28px 16px;
        color: #bbb;
        font-size: 13px;
    }
    .empty-state svg { display: block; margin: 0 auto 10px; opacity: .35; }

    /* ── Tenure chip ─────────────────────────────────────────────── */
    .tenure-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--ink);
        color: var(--gold-light);
        border-radius: 6px;
        padding: 5px 12px;
        font-family: 'Syne', sans-serif;
        font-size: 13px; font-weight: 600;
    }

    /* ── Utility ─────────────────────────────────────────────────── */
    .mt-6 { margin-top: 6px; }
    .mt-14 { margin-top: 14px; }
    .mt-20 { margin-top: 20px; }
    .mb-0  { margin-bottom: 0; }
    .gap-panel { display: flex; flex-direction: column; gap: 20px; }

    /* ── No employer placeholder ─────────────────────────────────── */
    .no-employer {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 16px;
        background: var(--surface);
        border: 1px dashed var(--surface-3);
        border-radius: 8px;
        font-size: 13px; color: #bbb;
    }

    /* ── Responsive ──────────────────────────────────────────────── */
    @media (max-width: 960px) {
        .body-grid { grid-template-columns: 1fr; }
        .hero-grid { grid-template-columns: auto 1fr; }
        .hero-status-col { grid-column: 1 / -1; flex-direction: row; align-items: center; }
    }
    @media (max-width: 640px) {
        .hero { padding: 32px 20px 28px; margin: 0 -16px 28px; border-radius: 0 0 16px 16px; }
        .emp-wrap { padding: 0 16px 60px; }
        .hero-name { font-size: 20px; }
        .stats-row { grid-template-columns: 1fr 1fr; }
    }

    /* ── Animations ──────────────────────────────────────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .45s ease both; }
    .delay-1 { animation-delay: .06s; }
    .delay-2 { animation-delay: .12s; }
    .delay-3 { animation-delay: .18s; }
    .delay-4 { animation-delay: .24s; }
    .delay-5 { animation-delay: .30s; }
</style>
@endpush

@section('content')
<div class="emp-wrap">

    {{-- ── Hero ──────────────────────────────────────────────────────── --}}
    <div class="hero fade-up">
        <div class="hero-grid">
            <div class="hero-avatar">
                {{ strtoupper(substr($employee->first_name ?? $user->name, 0, 1)) }}{{ strtoupper(substr($employee->last_name ?? '', 0, 1)) }}
            </div>

            <div>
                <div class="hero-name">
                    {{ $employee->first_name ?? '' }} {{ $employee->last_name ?? $user->name }}
                </div>
                <div class="hero-meta">
                    @if($currentRecord)
                        <span>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                            {{ $currentRecord->position }}
                        </span>
                    @endif
                    @if($currentEmployer)
                        <span>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            {{ $currentEmployer->name }}
                        </span>
                    @endif
                    @if($employee->province)
                        <span>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $employee->province }}
                        </span>
                    @endif
                    @if($employee->national_id)
                        <span>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            ID: {{ $employee->national_id }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="hero-status-col">
                @if($currentRecord)
                    <span class="hero-badge active">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg>
                        Employed
                    </span>
                @else
                    <span class="hero-badge">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg>
                        Not Employed
                    </span>
                @endif

                @if($pendingTransfer)
                    <span class="hero-badge pending">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        Transfer Pending
                    </span>
                @endif

                <span class="tenure-chip">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $totalYears }}y {{ $totalMonths }}m experience
                </span>
            </div>
        </div>
    </div>

    {{-- ── Stat Cards ──────────────────────────────────────────────────── --}}
    <div class="stats-row">
        <div class="stat-card fade-up delay-1" style="--accent:var(--gold);--accent-dim:var(--gold-dim)">
            <div class="stat-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            </div>
            <div class="stat-val">{{ $totalJobs }}</div>
            <div class="stat-label">Total Positions</div>
        </div>

        <div class="stat-card fade-up delay-2" style="--accent:var(--sky);--accent-dim:var(--sky-dim)">
            <div class="stat-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div class="stat-val">{{ $totalClaims }}</div>
            <div class="stat-label">Total Claims</div>
        </div>

        <div class="stat-card fade-up delay-3" style="--accent:var(--gold);--accent-dim:var(--gold-dim)">
            <div class="stat-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-val">{{ $pendingClaims }}</div>
            <div class="stat-label">Pending Claims</div>
        </div>

        <div class="stat-card fade-up delay-4" style="--accent:var(--emerald);--accent-dim:var(--emerald-dim)">
            <div class="stat-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="stat-val">{{ $resolvedClaims }}</div>
            <div class="stat-label">Resolved Claims</div>
        </div>

        <div class="stat-card fade-up delay-5" style="--accent:var(--sky);--accent-dim:var(--sky-dim)">
            <div class="stat-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </div>
            <div class="stat-val">{{ $totalTransfers }}</div>
            <div class="stat-label">Transfers</div>
        </div>

        <div class="stat-card fade-up delay-5" style="--accent:var(--emerald);--accent-dim:var(--emerald-dim)">
            <div class="stat-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div class="stat-val">{{ $approvedTransfers }}</div>
            <div class="stat-label">Approved Transfers</div>
        </div>
    </div>

    {{-- ── Body ────────────────────────────────────────────────────────── --}}
    <div class="body-grid">

        {{-- ── LEFT COLUMN ──────────────────────────────────────────────── --}}
        <div class="gap-panel">

            {{-- Current Employment --}}
            <div class="panel fade-up delay-2">
                <div class="panel-head">
                    <div class="section-label">Current Employment</div>
                </div>
                <div class="panel-body">
                    @if($currentRecord && $currentEmployer)
                        <div class="employer-card">
                            <div class="employer-logo">
                                {{ strtoupper(substr($currentEmployer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="employer-name">{{ $currentEmployer->name }}</div>
                                <div class="employer-pos">{{ $currentRecord->position }}</div>
                                <div class="employer-dates">
                                    Since {{ $currentRecord->start_date->format('M d, Y') }}
                                    @if($currentRecord->duration)
                                        &mdash; {{ $currentRecord->duration }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($currentRecord->conduct_rating)
                            <div class="mt-6">
                                <span class="conduct-tag {{ strtolower($currentRecord->conduct_rating) }}">
                                    ★ {{ ucfirst($currentRecord->conduct_rating) }} conduct
                                </span>
                            </div>
                        @endif
                    @else
                        <div class="no-employer">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            No active employment record.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Career Timeline --}}
            <div class="panel fade-up delay-3">
                <div class="panel-head">
                    <div class="section-label">Career Timeline</div>
                </div>
                <div class="panel-body">
                    @if($timeline->count())
                        <div class="timeline">
                            @foreach($timeline as $item)
                                <div class="tl-item">
                                    <div class="tl-dot {{ $item['is_active'] ? 'active' : '' }}"></div>
                                    <div class="tl-employer">{{ $item['employer'] }}</div>
                                    <div class="tl-pos">{{ $item['position'] }}</div>
                                    <div class="tl-period">
                                        {{ $item['start'] }} — {{ $item['end'] }}
                                        @if($item['duration'])
                                            <span class="tl-duration">{{ $item['duration'] }}</span>
                                        @endif
                                    </div>
                                    @if($item['conduct'])
                                        <span class="conduct-tag {{ strtolower($item['conduct']) }}">
                                            {{ ucfirst($item['conduct']) }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            No employment history found.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Claims --}}
            <div class="panel fade-up delay-4">
                <div class="panel-head">
                    <div class="section-label">Recent Claims</div>
                </div>
                <div class="panel-body">
                    @if($recentClaims->count())
                        @foreach($recentClaims as $claim)
                            @php
                                $statusClass = match(strtolower($claim->status)) {
                                    'resolved' => 'resolved',
                                    'rejected' => 'rejected',
                                    default    => 'pending',
                                };
                                $icon = match(strtolower($claim->status)) {
                                    'resolved' => '✓',
                                    'rejected' => '✕',
                                    default    => '⏳',
                                };
                            @endphp
                            <div class="claim-row">
                                <div class="claim-icon {{ $statusClass }}">{{ $icon }}</div>
                                <div>
                                    <div class="claim-title">{{ $claim->type ?? $claim->title ?? 'Claim #'.$claim->id }}</div>
                                    @if($claim->employmentRecord?->employer)
                                        <div class="claim-employer">{{ $claim->employmentRecord->employer->name }}</div>
                                    @endif
                                </div>
                                <span class="claim-status {{ $statusClass }}">{{ ucfirst($claim->status) }}</span>
                            </div>
                        @endforeach

                        @if($totalClaims > 5)
                            <div class="mt-14" style="text-align:right">
                                <a href="{{ route('employee.claims.index') }}"
                                   style="font-size:13px;color:var(--sky);font-weight:500;text-decoration:none;">
                                    View all {{ $totalClaims }} claims →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            No claims filed yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── RIGHT COLUMN ─────────────────────────────────────────────── --}}
        <div class="gap-panel">

            {{-- Transfer Request Banner --}}
            @if($pendingTransfer)
                <div class="transfer-banner fade-up delay-2">
                    <div class="transfer-icon">🔄</div>
                    <div>
                        <div class="transfer-label">Transfer Request Pending</div>
                        <div class="transfer-sub">
                            Submitted {{ $pendingTransfer->created_at->diffForHumans() }}
                            @if($pendingTransfer->to_employer_id)
                                · To: {{ $pendingTransfer->toEmployer->name ?? 'New Employer' }}
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Conduct Summary --}}
            <div class="panel fade-up delay-2">
                <div class="panel-head">
                    <div class="section-label">Conduct Summary</div>
                </div>
                <div class="panel-body">
                    @if($conductSummary->count())
                        @php $maxCount = $conductSummary->max(); @endphp
                        <div class="conduct-bars">
                            @foreach($conductSummary as $rating => $count)
                                <div class="conduct-bar-row">
                                    <span class="conduct-bar-label">{{ ucfirst($rating) }}</span>
                                    <div class="conduct-bar-track">
                                        <div class="conduct-bar-fill {{ strtolower($rating) }}"
                                             style="width: {{ $maxCount > 0 ? round($count / $maxCount * 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <span class="conduct-bar-count">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state" style="padding:14px 0">No conduct ratings recorded.</div>
                    @endif
                </div>
            </div>

            {{-- Skills --}}
            <div class="panel fade-up delay-3">
                <div class="panel-head">
                    <div class="section-label">Skills</div>
                </div>
                <div class="panel-body">
                    @if(count($skills))
                        <div class="skills-wrap">
                            @foreach($skills as $skill)
                                <span class="skill-pill">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state" style="padding:14px 0">No skills listed.</div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="panel fade-up delay-4">
                <div class="panel-head">
                    <div class="section-label">Quick Actions</div>
                </div>
                <div class="panel-body" style="display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('employee.claims.create') }}"
                       style="display:flex;align-items:center;gap:10px;padding:11px 14px;background:var(--surface);border:1px solid var(--surface-3);border-radius:8px;text-decoration:none;color:var(--ink);font-size:14px;font-weight:500;transition:background .15s,border-color .15s;"
                       onmouseover="this.style.background='var(--gold-dim)';this.style.borderColor='var(--gold)'"
                       onmouseout="this.style.background='var(--surface)';this.style.borderColor='var(--surface-3)'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                        File a Claim
                    </a>

                    @if(!$pendingTransfer)
                    <a href="#"
                       style="display:flex;align-items:center;gap:10px;padding:11px 14px;background:var(--surface);border:1px solid var(--surface-3);border-radius:8px;text-decoration:none;color:var(--ink);font-size:14px;font-weight:500;transition:background .15s,border-color .15s;"
                       onmouseover="this.style.background='var(--sky-dim)';this.style.borderColor='var(--sky)'"
                       onmouseout="this.style.background='var(--surface)';this.style.borderColor='var(--surface-3)'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        Request Transfer
                    </a>
                    @endif

                    <a href="#"
                       style="display:flex;align-items:center;gap:10px;padding:11px 14px;background:var(--surface);border:1px solid var(--surface-3);border-radius:8px;text-decoration:none;color:var(--ink);font-size:14px;font-weight:500;transition:background .15s,border-color .15s;"
                       onmouseover="this.style.background='var(--emerald-dim)';this.style.borderColor='var(--emerald)'"
                       onmouseout="this.style.background='var(--surface)';this.style.borderColor='var(--surface-3)'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Edit Profile
                    </a>
                </div>
            </div>

        </div>{{-- end right --}}
    </div>{{-- end body-grid --}}

</div>{{-- end emp-wrap --}}
@endsection