@extends('layouts.app')
@section('title', $employer->name . ' — Employer Profile')

@section('content')

<style>
/* ═══════════════════════════════════════════════════════
   EMPLOYER SHOW PAGE
═══════════════════════════════════════════════════════ */

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
.anim   { animation: fadeUp .32s ease-out both; }
.anim-1 { animation-delay: .04s; }
.anim-2 { animation-delay: .09s; }
.anim-3 { animation-delay: .14s; }
.anim-4 { animation-delay: .19s; }

/* ── Breadcrumb ─────────────────────────────────────────── */
.ep-breadcrumb {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .75rem;
    margin-bottom: 1.1rem;
    color: var(--slate-400);
}
.ep-breadcrumb a {
    color: var(--navy-600);
    text-decoration: none;
    font-weight: 600;
}
.ep-breadcrumb a:hover { text-decoration: underline; }
.ep-breadcrumb i { font-size: .58rem; color: var(--slate-300); }

/* ── Hero ───────────────────────────────────────────────── */
.ep-hero {
    background: var(--navy-900);
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 1.25rem;
}

.ep-hero-banner {
    height: 100px;
    background: linear-gradient(125deg, var(--navy-700) 0%, #1a4060 55%, var(--navy-600) 100%);
    position: relative;
    overflow: hidden;
}

.ep-hero-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 15% 60%, rgba(0,158,79,.15) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 30%, rgba(255,255,255,.04) 0%, transparent 45%);
}

/* Decorative rings */
.ep-hero-banner::after {
    content: '';
    position: absolute;
    right: -50px;
    top: -50px;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    border: 36px solid rgba(255,255,255,.035);
}

.ep-hero-body { padding: 0 1.75rem 1.5rem; position: relative; }

/* Logo / avatar */
.ep-logo-wrap {
    display: inline-block;
    margin-top: -40px;
    margin-bottom: .75rem;
}

.ep-logo {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-md);
    border: 3px solid var(--navy-900);
    background: linear-gradient(135deg, var(--navy-600), var(--navy-500));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    font-weight: 800;
    color: rgba(255,255,255,.9);
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,.4);
    flex-shrink: 0;
}

.ep-logo img { width: 100%; height: 100%; object-fit: contain; background: #fff; padding: 6px; }

/* Identity */
.ep-name {
    font-size: 1.25rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 .3rem;
    line-height: 1.25;
}

.ep-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .5rem;
    margin-bottom: .9rem;
}

.ep-meta-item {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .75rem;
    color: rgba(255,255,255,.5);
}

/* Status badge */
.ep-status {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: 4px 11px;
    border-radius: 20px;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
}
.eps-verified  { background: rgba(5,150,105,.25);  color: #6EE7A8; }
.eps-pending   { background: rgba(217,119,6,.25);  color: #FCD34D; }
.eps-rejected  { background: rgba(220,38,38,.25);  color: #FCA5A5; }
.eps-suspended { background: rgba(148,163,184,.15);color: #94A3B8; }

/* RDB chip */
.rdb-chip {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.13);
    padding: 3px 10px 3px 6px;
    border-radius: 20px;
    font-size: .71rem;
    font-weight: 700;
    color: rgba(255,255,255,.8);
    font-family: 'DM Mono', monospace;
    letter-spacing: .04em;
}
.rdb-chip .chip-icon {
    width: 16px;
    height: 16px;
    background: var(--navy-600);
    border-radius: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .55rem;
    color: #fff;
    flex-shrink: 0;
}

/* Quick stats */
.ep-stats {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255,255,255,.07);
}
.ep-stat {
    flex: 1;
    min-width: 80px;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: var(--radius-sm);
    padding: .55rem .75rem;
    text-align: center;
}
.ep-stat-val {
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
}
.ep-stat-lbl {
    font-size: .62rem;
    color: rgba(255,255,255,.38);
    text-transform: uppercase;
    letter-spacing: .07em;
    margin-top: 1px;
}

/* Action bar */
.ep-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .5rem;
    padding: .85rem 1.75rem;
    border-top: 1px solid rgba(255,255,255,.06);
    background: rgba(0,0,0,.15);
}
.btn-ep {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .42rem .95rem;
    border-radius: var(--radius-sm);
    font-size: .78rem;
    font-weight: 700;
    cursor: pointer;
    border: 1px solid transparent;
    transition: var(--transition);
    text-decoration: none;
    letter-spacing: .01em;
}
.btn-ep-verify {
    background: var(--green-500);
    border-color: var(--green-400);
    color: #fff;
}
.btn-ep-verify:hover {
    background: var(--green-400);
    color: #fff;
    box-shadow: 0 0 0 3px rgba(0,158,79,.25);
}
.btn-ep-reject {
    background: rgba(220,38,38,.15);
    border-color: rgba(220,38,38,.3);
    color: #FCA5A5;
}
.btn-ep-reject:hover { background: rgba(220,38,38,.25); color: #fff; }
.btn-ep-suspend {
    background: rgba(245,158,11,.12);
    border-color: rgba(245,158,11,.25);
    color: #FCD34D;
}
.btn-ep-suspend:hover { background: rgba(245,158,11,.2); color: #fff; }
.btn-ep-ghost {
    background: rgba(255,255,255,.07);
    border-color: rgba(255,255,255,.12);
    color: rgba(255,255,255,.7);
}
.btn-ep-ghost:hover { background: rgba(255,255,255,.12); color: #fff; }

/* ── Info card ──────────────────────────────────────────── */
.info-card {
    background: #fff;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 1.1rem;
}
.info-card-header {
    display: flex;
    align-items: center;
    gap: .6rem;
    padding: .8rem 1.15rem;
    border-bottom: 1px solid var(--slate-100);
    background: var(--slate-50);
}
.ic-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    flex-shrink: 0;
}
.ic-navy   { background: var(--blue-100); color: var(--navy-600); }
.ic-green  { background: #D1FAE5; color: #059669; }
.ic-amber  { background: #FEF3C7; color: #D97706; }
.ic-red    { background: #FEE2E2; color: #DC2626; }
.info-card-header-title { font-size: .82rem; font-weight: 700; color: var(--slate-800); }
.info-card-body { padding: 1rem 1.15rem; }

/* Data rows */
.data-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: .75rem;
    padding: .52rem 0;
    border-bottom: 1px solid var(--slate-100);
}
.data-row:last-child { border-bottom: none; }
.data-label {
    font-size: .7rem;
    font-weight: 700;
    color: var(--slate-400);
    text-transform: uppercase;
    letter-spacing: .06em;
    white-space: nowrap;
    flex-shrink: 0;
    padding-top: 1px;
}
.data-value {
    font-size: .81rem;
    font-weight: 500;
    color: var(--slate-800);
    text-align: right;
    line-height: 1.45;
}
.data-value.mono {
    font-family: 'DM Mono', monospace;
    font-size: .77rem;
    color: var(--navy-700);
}
.data-value a { color: var(--navy-600); text-decoration: none; }
.data-value a:hover { text-decoration: underline; }

/* ── Tabs ───────────────────────────────────────────────── */
.ep-tabs {
    display: flex;
    gap: .25rem;
    background: var(--slate-100);
    border-radius: var(--radius-md);
    padding: 3px;
    margin-bottom: 1.1rem;
}
.ep-tab {
    flex: 1;
    text-align: center;
    padding: .44rem .6rem;
    border-radius: 7px;
    font-size: .78rem;
    font-weight: 600;
    color: var(--slate-400);
    cursor: pointer;
    transition: var(--transition);
    border: none;
    background: transparent;
    white-space: nowrap;
}
.ep-tab.active {
    background: #fff;
    color: var(--navy-700);
    box-shadow: var(--shadow-sm);
}
.tab-pane-ep { display: none; }
.tab-pane-ep.active { display: block; }

/* ── Section head ───────────────────────────────────────── */
.section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .85rem;
}
.section-head-title {
    font-size: .88rem;
    font-weight: 800;
    color: var(--slate-800);
    display: flex;
    align-items: center;
    gap: .45rem;
}
.section-head-title i { color: var(--navy-600); }

/* ── Employee roster row ────────────────────────────────── */
.roster-row {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: .75rem 1rem;
    border-radius: var(--radius-md);
    border: 1px solid var(--slate-200);
    background: #fff;
    margin-bottom: .55rem;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
    text-decoration: none;
}
.roster-row:hover {
    border-color: var(--slate-300);
    box-shadow: var(--shadow-md);
    background: #FAFBFF;
}
.roster-avatar {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm);
    background: linear-gradient(135deg, var(--navy-600), var(--navy-500));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 800;
    color: #fff;
    flex-shrink: 0;
}
.roster-name {
    font-size: .83rem;
    font-weight: 700;
    color: var(--slate-800);
    line-height: 1.3;
}
.roster-meta {
    font-size: .71rem;
    color: var(--slate-400);
    margin-top: 1px;
}
.roster-badge-active {
    background: #D1FAE5;
    color: #065F46;
    font-size: .65rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 10px;
    white-space: nowrap;
}
.roster-badge-exit {
    background: var(--slate-100);
    color: var(--slate-500);
    font-size: .65rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 10px;
    white-space: nowrap;
}

/* Duration pill */
.dur-pill {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    font-size: .7rem;
    color: var(--slate-400);
    background: var(--slate-50);
    border: 1px solid var(--slate-200);
    padding: 2px 8px;
    border-radius: 10px;
    white-space: nowrap;
}

/* ── Feedback card ──────────────────────────────────────── */
.fb-card {
    background: #fff;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-md);
    padding: 1rem;
    margin-bottom: .65rem;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.fb-card::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--navy-600);
    border-radius: 0 2px 2px 0;
}
.fb-card:hover { box-shadow: var(--shadow-md); }
.fb-employee-name { font-size: .82rem; font-weight: 700; color: var(--slate-800); }
.fb-date { font-size: .7rem; color: var(--slate-400); }
.fb-body {
    font-size: .8rem;
    color: var(--slate-600);
    line-height: 1.6;
    margin-top: .45rem;
}
.stars { color: #F59E0B; font-size: .78rem; letter-spacing: 1px; }

/* ── Status banners ─────────────────────────────────────── */
.pending-banner {
    background: linear-gradient(135deg, #FFFBEB, #FEF9EC);
    border: 1px solid #FDE68A;
    border-radius: var(--radius-md);
    padding: .9rem 1.1rem;
    display: flex;
    align-items: flex-start;
    gap: .8rem;
    margin-bottom: 1rem;
}
.pending-banner-icon {
    width: 32px;
    height: 32px;
    background: #FEF3C7;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .9rem;
    color: #D97706;
    flex-shrink: 0;
}
.pending-banner-text { font-size: .79rem; color: #92400E; line-height: 1.6; }
.pending-banner-text strong { font-weight: 700; }

.verified-banner {
    background: linear-gradient(135deg, #ECFDF5, #F0FDF7);
    border: 1px solid #A7F3D0;
    border-radius: var(--radius-md);
    padding: .9rem 1.1rem;
    display: flex;
    align-items: center;
    gap: .8rem;
    margin-bottom: 1rem;
}
.vb-icon {
    width: 38px;
    height: 38px;
    background: #D1FAE5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #059669;
    flex-shrink: 0;
}
.vb-text strong { display: block; font-size: .82rem; font-weight: 700; color: #065F46; }
.vb-text span   { font-size: .72rem; color: #059669; }

.rejected-banner {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: var(--radius-md);
    padding: .9rem 1.1rem;
    margin-bottom: 1rem;
}
.rb-title { font-size: .8rem; font-weight: 700; color: #991B1B; margin-bottom: .3rem; display: flex; align-items: center; gap: .4rem; }
.rb-body  { font-size: .77rem; color: #B91C1C; line-height: 1.6; }

/* ── Modal ──────────────────────────────────────────────── */
.modal-content {
    border: none;
    border-radius: var(--radius-lg);
    box-shadow: 0 24px 64px rgba(0,0,0,.18);
    overflow: hidden;
}
.mh-navy    { background: linear-gradient(135deg, var(--navy-800), var(--navy-700)); padding: 1.05rem 1.3rem; border: none; }
.mh-danger  { background: linear-gradient(135deg, #7F1D1D, #991B1B); padding: 1.05rem 1.3rem; border: none; }
.mh-warning { background: linear-gradient(135deg, #78350F, #92400E); padding: 1.05rem 1.3rem; border: none; }
.mh-icon {
    width: 32px; height: 32px;
    background: rgba(255,255,255,.15);
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem; color: #fff; flex-shrink: 0;
}
.mh-title { font-size: .93rem; font-weight: 800; color: #fff; margin: 0; }
.mh-sub   { font-size: .73rem; color: rgba(255,255,255,.5); margin: .12rem 0 0; }
.modal-content .modal-body    { padding: 1.3rem; }
.modal-content .modal-footer  { padding: .85rem 1.3rem; border-top: 1px solid var(--slate-200); background: var(--slate-50); }

/* Employer mini-card in modal */
.m-emp-card {
    display: flex;
    align-items: center;
    gap: .85rem;
    background: var(--slate-50);
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-md);
    padding: .8rem 1rem;
    margin-bottom: 1.1rem;
}
.m-emp-logo {
    width: 40px; height: 40px;
    border-radius: var(--radius-sm);
    background: linear-gradient(135deg, var(--navy-600), var(--navy-500));
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 800; color: #fff; flex-shrink: 0;
}
.m-emp-name { font-size: .84rem; font-weight: 700; color: var(--slate-800); }
.m-emp-reg  { font-size: .71rem; font-family: 'DM Mono', monospace; color: var(--slate-400); margin-top: 1px; }

/* Checklist */
.check-list { list-style: none; padding: 0; margin: 0; }
.check-list li {
    display: flex; align-items: center; gap: .7rem;
    padding: .5rem .7rem;
    border-radius: var(--radius-sm);
    font-size: .81rem;
    color: var(--slate-700);
    margin-bottom: 4px;
    border: 1px solid var(--slate-200);
    background: #fff;
    cursor: pointer;
    transition: var(--transition);
}
.check-list li:hover { background: var(--slate-50); }
.check-list li input[type=checkbox] { accent-color: var(--navy-600); width: 14px; height: 14px; flex-shrink: 0; }
.check-list li.checked { background: #EBF2FF; border-color: #BFDBFE; color: var(--navy-700); }

/* Empty state */
.empty-state { text-align: center; padding: 2.5rem 1rem; }
.empty-state i { font-size: 1.8rem; display: block; margin-bottom: .5rem; opacity: .25; color: var(--slate-400); }
.empty-state p { font-size: .79rem; color: var(--slate-400); margin: 0; }
</style>




{{-- Breadcrumb --}}
<div class="ep-breadcrumb anim">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <i class="bi bi-chevron-right"></i>
    <a href="{{ route('admin.employers.index') }}">Employers</a>
    <i class="bi bi-chevron-right"></i>
    <span>{{ $employer->name }}</span>
</div>

<div class="row g-3">

    {{-- ══════════════════════════════════════════════════════
         LEFT — Hero + Sidebar info
    ══════════════════════════════════════════════════════ --}}
    <div class="col-lg-4">

        {{-- Hero card --}}
        <div class="ep-hero anim anim-1">

            <div class="ep-hero-banner"></div>

            <div class="ep-hero-body">

                <div class="ep-logo-wrap">
                    <div class="ep-logo">
                        @if($employer->logo)
                            <img src="{{ asset('image/' . $employer->logo) }}" alt="{{ $employer->name }}">
                        @else
                            {{ strtoupper(substr($employer->name, 0, 2)) }}
                        @endif
                    </div>
                </div>

                <h2 class="ep-name">{{ $employer->name }}</h2>

                <div class="ep-meta">
                    {{-- RDB / Registration chip --}}
                    @if($employer->registration_number || $employer->tin_number)
                    <span class="rdb-chip">
                        <span class="chip-icon"><i class="bi bi-building"></i></span>
                        {{ $employer->registration_number ?? $employer->tin_number }}
                    </span>
                    @endif

                    {{-- Status --}}
                    @php
                        $sMap = [
                            'verified'  => ['cls' => 'eps-verified',  'icon' => 'patch-check-fill', 'label' => 'Verified'],
                            'pending'   => ['cls' => 'eps-pending',   'icon' => 'hourglass-split',  'label' => 'Pending Review'],
                            'rejected'  => ['cls' => 'eps-rejected',  'icon' => 'x-circle-fill',    'label' => 'Rejected'],
                            'suspended' => ['cls' => 'eps-suspended', 'icon' => 'pause-circle-fill','label' => 'Suspended'],
                        ];
                        $si = $sMap[$employer->status] ?? $sMap['pending'];
                    @endphp
                    <span class="ep-status {{ $si['cls'] }}">
                        <i class="bi bi-{{ $si['icon'] }}"></i> {{ $si['label'] }}
                    </span>
                </div>

                {{-- Contact meta --}}
                <div class="d-flex flex-column gap-1 mb-1">
                    @if($employer->email)
                    <div class="ep-meta-item">
                        <i class="bi bi-envelope"></i>
                        <span>{{ $employer->email }}</span>
                    </div>
                    @endif
                    @if($employer->phone)
                    <div class="ep-meta-item">
                        <i class="bi bi-telephone"></i>
                        <span>{{ $employer->phone }}</span>
                    </div>
                    @endif
                    @if($employer->website)
                    <div class="ep-meta-item">
                        <i class="bi bi-globe2"></i>
                        <a href="{{ $employer->website }}" target="_blank"
                           style="color:rgba(255,255,255,.55);text-decoration:none;">
                            {{ parse_url($employer->website, PHP_URL_HOST) ?? $employer->website }}
                        </a>
                    </div>
                    @endif
                    @if($employer->district)
                    <div class="ep-meta-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>{{ $employer->district }}, {{ $employer->province }}, Rwanda</span>
                    </div>
                    @endif
                </div>

                {{-- Quick stats --}}
                <div class="ep-stats">
                    <div class="ep-stat">
                        <div class="ep-stat-val">{{ $stats['total_employees'] }}</div>
                        <div class="ep-stat-lbl">Total</div>
                    </div>
                    <div class="ep-stat">
                        <div class="ep-stat-val" style="color:#6EE7A8;">{{ $stats['active_employees'] }}</div>
                        <div class="ep-stat-lbl">Active</div>
                    </div>
                    <div class="ep-stat">
                        <div class="ep-stat-val">{{ $stats['exited_employees'] }}</div>
                        <div class="ep-stat-lbl">Exited</div>
                    </div>
                    <div class="ep-stat">
                        <div class="ep-stat-val">
                            {{ $stats['avg_rating'] ? number_format($stats['avg_rating'], 1) : '—' }}
                        </div>
                        <div class="ep-stat-lbl">Avg Rating</div>
                    </div>
                    <div class="ep-stat">
                        <div class="ep-stat-val">
                            {{ $stats['avg_tenure_months'] ? round($stats['avg_tenure_months']) . 'm' : '—' }}
                        </div>
                        <div class="ep-stat-lbl">Avg Tenure</div>
                    </div>
                </div>
            </div>

            {{-- Action bar --}}
            <div class="ep-actions">
                @if($employer->status === 'pending')
                    <button class="btn-ep btn-ep-verify"
                            data-bs-toggle="modal"
                            data-bs-target="#verifyModal">
                        <i class="bi bi-patch-check-fill"></i> Verify
                    </button>
                    <button class="btn-ep btn-ep-reject"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle"></i> Reject
                    </button>

                @elseif($employer->status === 'verified')
                    <span class="btn-ep"
                          style="background:rgba(5,150,105,.2);border-color:rgba(5,150,105,.3);color:#6EE7A8;cursor:default;">
                        <i class="bi bi-patch-check-fill"></i> Verified
                    </span>
                    <button class="btn-ep btn-ep-suspend"
                            data-bs-toggle="modal"
                            data-bs-target="#suspendModal">
                        <i class="bi bi-pause-circle"></i> Suspend
                    </button>

                @elseif(in_array($employer->status, ['rejected', 'suspended']))
                    <button class="btn-ep btn-ep-verify"
                            data-bs-toggle="modal"
                            data-bs-target="#verifyModal">
                        <i class="bi bi-arrow-clockwise"></i> Re-verify
                    </button>
                @endif

                <a href="{{ route('admin.employers.index') }}"
                   class="btn-ep btn-ep-ghost ms-auto">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- Organisation details --}}
        <div class="info-card anim anim-2">
            <div class="info-card-header">
                <div class="ic-icon ic-navy"><i class="bi bi-building-fill"></i></div>
                <span class="info-card-header-title">Organisation Details</span>
            </div>
            <div class="info-card-body">
                <div class="data-row">
                    <span class="data-label">Legal Name</span>
                    <span class="data-value">{{ $employer->name }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Sector</span>
                    <span class="data-value">{{ $employer->sector_label }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">TIN</span>
                    <span class="data-value mono">{{ $employer->tin_number ?? '—' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Reg. No</span>
                    <span class="data-value mono">{{ $employer->registration_number ?? '—' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Province</span>
                    <span class="data-value">{{ $employer->province ?? '—' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">District</span>
                    <span class="data-value">{{ $employer->district ?? '—' }}</span>
                </div>
                @if($employer->address)
                <div class="data-row">
                    <span class="data-label">Address</span>
                    <span class="data-value">{{ $employer->address }}</span>
                </div>
                @endif
                @if($employer->website)
                <div class="data-row">
                    <span class="data-label">Website</span>
                    <span class="data-value">
                        <a href="{{ $employer->website }}" target="_blank">
                            {{ parse_url($employer->website, PHP_URL_HOST) }}
                        </a>
                    </span>
                </div>
                @endif
                <div class="data-row">
                    <span class="data-label">Registered</span>
                    <span class="data-value">
                        {{ $employer->created_at->format('d M Y') }}
                        <span class="d-block" style="font-size:.7rem;color:var(--slate-400);">
                            {{ $employer->created_at->diffForHumans() }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Account owner --}}
        <div class="info-card anim anim-3">
            <div class="info-card-header">
                <div class="ic-icon ic-navy"><i class="bi bi-person-badge-fill"></i></div>
                <span class="info-card-header-title">Account Owner</span>
            </div>
            <div class="info-card-body">
                <div class="data-row">
                    <span class="data-label">Name</span>
                    <span class="data-value">{{ $employer->user->name }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Email</span>
                    <span class="data-value">
                        <a href="mailto:{{ $employer->user->email }}">
                            {{ $employer->user->email }}
                        </a>
                    </span>
                </div>
                <div class="data-row">
                    <span class="data-label">Joined</span>
                    <span class="data-value">{{ $employer->user->created_at->format('d M Y') }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Verified</span>
                    <span class="data-value">
                        @if($employer->user->email_verified_at)
                            <span style="color:#059669;font-size:.78rem;">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                {{ $employer->user->email_verified_at->format('d M Y') }}
                            </span>
                        @else
                            <span style="color:#D97706;font-size:.78rem;">Not verified</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Verification trail --}}
        @if($employer->status !== 'pending')
        <div class="info-card anim anim-4">
            <div class="info-card-header">
                <div class="ic-icon {{ $employer->status === 'verified' ? 'ic-green' : 'ic-red' }}">
                    <i class="bi bi-{{ $employer->status === 'verified' ? 'patch-check' : 'x-circle' }}-fill"></i>
                </div>
                <span class="info-card-header-title">Verification Record</span>
            </div>
            <div class="info-card-body">
                <div class="data-row">
                    <span class="data-label">Decision</span>
                    <span class="data-value">{{ ucfirst($employer->status) }}</span>
                </div>
                @if($employer->verified_by)
                <div class="data-row">
                    <span class="data-label">By</span>
                    <span class="data-value">{{ optional($employer->verifiedBy)->name ?? '—' }}</span>
                </div>
                @endif
                @if($employer->verified_at)
                <div class="data-row">
                    <span class="data-label">At</span>
                    <span class="data-value">
                        {{ \Carbon\Carbon::parse($employer->verified_at)->format('d M Y, H:i') }}
                    </span>
                </div>
                @endif
                @if($employer->rejection_reason)
                <div class="data-row" style="flex-direction:column;gap:.3rem;">
                    <span class="data-label">Reason</span>
                    <span class="data-value"
                          style="text-align:left;width:100%;background:var(--slate-50);
                                 padding:.5rem .65rem;border-radius:6px;
                                 border:1px solid var(--slate-200);font-size:.77rem;color:var(--slate-600);">
                        {{ $employer->rejection_reason }}
                    </span>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>

    {{-- ══════════════════════════════════════════════════════
         RIGHT — Tabs: Workforce · Feedback · Description
    ══════════════════════════════════════════════════════ --}}
    <div class="col-lg-8">

        {{-- Status banners --}}
        @if($employer->status === 'pending')
        <div class="pending-banner anim anim-1">
            <div class="pending-banner-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="pending-banner-text">
                <strong>Awaiting verification.</strong>
                This employer has not yet been reviewed. Check the registration details
                and workforce records before approving.
            </div>
        </div>

        @elseif($employer->status === 'verified')
        <div class="verified-banner anim anim-1">
            <div class="vb-icon"><i class="bi bi-patch-check-fill"></i></div>
            <div class="vb-text">
                <strong>Employer Verified</strong>
                <span>
                    Approved {{ \Carbon\Carbon::parse($employer->verified_at)->format('d M Y') }}
                    @if($employer->verified_by) by {{ optional($employer->verifiedBy)->name }} @endif
                </span>
            </div>
        </div>

        @elseif($employer->status === 'rejected')
        <div class="rejected-banner anim anim-1">
            <div class="rb-title"><i class="bi bi-x-circle-fill"></i> Registration Rejected</div>
            @if($employer->rejection_reason)
                <div class="rb-body">{{ $employer->rejection_reason }}</div>
            @endif
        </div>
        @endif

        {{-- Tabs --}}
        <div class="ep-tabs anim anim-2">
            <button class="ep-tab active" data-tab="workforce">
                <i class="bi bi-people me-1"></i>
                Workforce
                <span class="badge ms-1"
                      style="background:var(--navy-600);color:#fff;font-size:.6rem;padding:2px 5px;">
                    {{ $stats['active_employees'] }}
                </span>
            </button>
            <button class="ep-tab" data-tab="history">
                <i class="bi bi-clock-history me-1"></i> All Records
            </button>
            <button class="ep-tab" data-tab="feedback">
                <i class="bi bi-chat-square-text me-1"></i> Feedback
            </button>
            @if($employer->description)
            <button class="ep-tab" data-tab="about">
                <i class="bi bi-info-circle me-1"></i> About
            </button>
            @endif
        </div>

        {{-- ── Tab: Active Workforce ───────────────────────── --}}
        <div class="tab-pane-ep active anim anim-3" id="tab-workforce">

            <div class="section-head">
                <div class="section-head-title">
                    <i class="bi bi-person-check-fill"></i>
                    Current Employees
                </div>
                <span style="font-size:.74rem;color:var(--slate-400);">
                    {{ $stats['active_employees'] }} active
                </span>
            </div>

            @forelse($employer->activeEmploymentRecords as $record)
            @php
                $emp   = $record->employee;
                $start = \Carbon\Carbon::parse($record->start_date);
                $dur   = $start->diff(now());
            @endphp
            <a href="{{ route('admin.employees.show', $emp) }}" class="roster-row">
                <div class="roster-avatar">
                    {{ strtoupper(substr($emp->name, 0, 2)) }}
                </div>
                <div class="flex-fill">
                    <div class="roster-name">{{ $emp->name }}</div>
                    <div class="roster-meta">
                        {{ $record->position ?? $record->job_title ?? 'Employee' }}
                        &nbsp;·&nbsp; {{ $emp->district ?? 'Rwanda' }}
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end gap-1">
                    <span class="roster-badge-active">● Active</span>
                    <span class="dur-pill">
                        <i class="bi bi-clock"></i>
                        @if($dur->y) {{ $dur->y }}y @endif
                        {{ $dur->m }}m
                    </span>
                </div>
            </a>
            @empty
            <div class="info-card">
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <p>No active employees at this organisation.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- ── Tab: All Employment Records ─────────────────── --}}
        <div class="tab-pane-ep" id="tab-history">

            <div class="section-head">
                <div class="section-head-title">
                    <i class="bi bi-clock-history"></i>
                    All Employment Records
                </div>
                <span style="font-size:.74rem;color:var(--slate-400);">
                    {{ $employer->employmentRecords->count() }} record(s)
                </span>
            </div>

            @forelse($employer->employmentRecords as $record)
            @php
                $emp      = $record->employee;
                $isActive = is_null($record->end_date);
                $start    = \Carbon\Carbon::parse($record->start_date);
                $end      = $isActive ? now() : \Carbon\Carbon::parse($record->end_date);
                $dur      = $start->diff($end);
            @endphp
            <a href="{{ route('admin.employees.show', $emp) }}" class="roster-row">
                <div class="roster-avatar">
                    {{ strtoupper(substr($emp->name, 0, 2)) }}
                </div>
                <div class="flex-fill">
                    <div class="roster-name">{{ $emp->name }}</div>
                    <div class="roster-meta">
                        {{ $record->position ?? 'Employee' }}
                        &nbsp;·&nbsp;
                        {{ $start->format('M Y') }} — {{ $isActive ? 'Present' : $end->format('M Y') }}
                    </div>
                    @if(!$isActive && $record->exit_reason)
                    <div class="roster-meta" style="margin-top:2px;">
                        <i class="bi bi-box-arrow-right me-1"></i>{{ $record->exit_reason }}
                    </div>
                    @endif
                </div>
                <div class="d-flex flex-column align-items-end gap-1">
                    @if($isActive)
                        <span class="roster-badge-active">● Active</span>
                    @else
                        <span class="roster-badge-exit">Exited</span>
                    @endif
                    <span class="dur-pill">
                        <i class="bi bi-clock"></i>
                        @if($dur->y) {{ $dur->y }}y @endif {{ $dur->m }}m
                    </span>
                </div>
            </a>
            @empty
            <div class="info-card">
                <div class="empty-state">
                    <i class="bi bi-briefcase"></i>
                    <p>No employment records linked to this employer.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- ── Tab: Feedback ────────────────────────────────── --}}
        <div class="tab-pane-ep" id="tab-feedback">

            <div class="section-head">
                <div class="section-head-title">
                    <i class="bi bi-chat-square-text-fill"></i>
                    Employee Feedback
                </div>
                @if($stats['avg_rating'])
                <div class="stars" style="font-size:.85rem;">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= round($stats['avg_rating']) ? '-fill' : '' }}"></i>
                    @endfor
                    <span style="font-size:.75rem;color:var(--slate-400);margin-left:.3rem;">
                        {{ number_format($stats['avg_rating'], 1) }} avg
                    </span>
                </div>
                @endif
            </div>

            @php
                $feedbacks = $employer->employmentRecords
                    ->map(fn($r) => $r->feedback)
                    ->filter();
            @endphp

            @forelse($feedbacks as $fb)
            <div class="fb-card">
                <div class="d-flex align-items-start justify-content-between gap-2">
                    <div>
                        <div class="fb-employee-name">
                            {{ optional(optional($fb->employmentRecord)->employee)->name ?? '—' }}
                        </div>
                        <div class="fb-date">
                            {{ $fb->created_at->format('d M Y') }}
                            · {{ $fb->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if($fb->rating)
                    <div class="stars text-end">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $fb->rating ? '-fill' : '' }}"></i>
                        @endfor
                        <div style="font-size:.67rem;color:var(--slate-400);text-align:right;margin-top:1px;">
                            {{ number_format($fb->rating, 1) }}/5
                        </div>
                    </div>
                    @endif
                </div>
                <p class="fb-body">{{ $fb->comments ?? $fb->content ?? '—' }}</p>
                @if($fb->is_moderated ?? false)
                <div style="font-size:.69rem;color:var(--slate-400);display:flex;align-items:center;gap:.3rem;margin-top:.3rem;">
                    <i class="bi bi-shield-check" style="color:#059669;"></i> Moderated
                </div>
                @endif
            </div>
            @empty
            <div class="info-card">
                <div class="empty-state">
                    <i class="bi bi-chat-square-text"></i>
                    <p>No feedback has been recorded for this employer yet.</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- ── Tab: About ───────────────────────────────────── --}}
        @if($employer->description)
        <div class="tab-pane-ep" id="tab-about">
            <div class="info-card">
                <div class="info-card-header">
                    <div class="ic-icon ic-navy"><i class="bi bi-file-text-fill"></i></div>
                    <span class="info-card-header-title">About {{ $employer->name }}</span>
                </div>
                <div class="info-card-body">
                    <p style="font-size:.83rem;color:var(--slate-600);line-height:1.75;margin:0;">
                        {{ $employer->description }}
                    </p>
                </div>
            </div>
        </div>
        @endif

    </div>{{-- /col-lg-8 --}}
</div>


{{-- ═══════════════════════════════════════════════════════════
     MODALS
═══════════════════════════════════════════════════════════ --}}

{{-- ── Verify Modal ────────────────────────────────────────── --}}
<div class="modal fade" id="verifyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="mh-navy">
                <div class="d-flex align-items-center gap-2">
                    <div class="mh-icon"><i class="bi bi-patch-check-fill"></i></div>
                    <div>
                        <p class="mh-title">Verify Employer</p>
                        <p class="mh-sub">Approve this organisation in the national registry</p>
                    </div>
                </div>
                <button type="button"
                        class="btn-close btn-close-white ms-auto d-block mt-n3"
                        data-bs-dismiss="modal"></button>
            </div>

            <form method="POST"
                  action="{{ route('admin.employers.verify', $employer) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="action" value="verify">

                <div class="modal-body">

                    <div class="m-emp-card">
                        <div class="m-emp-logo">
                            {{ strtoupper(substr($employer->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="m-emp-name">{{ $employer->name }}</div>
                            <div class="m-emp-reg">
                                {{ $employer->registration_number ?? $employer->tin_number ?? 'No Reg. Number' }}
                            </div>
                        </div>
                        <span class="ms-auto ep-status eps-pending" style="font-size:.67rem;">
                            <i class="bi bi-hourglass-split"></i> Pending
                        </span>
                    </div>

                    <div style="font-size:.75rem;font-weight:700;color:var(--slate-500);
                                margin-bottom:.55rem;letter-spacing:.05em;text-transform:uppercase;">
                        Pre-approval checklist
                    </div>
                    <ul class="check-list mb-3">
                        <li onclick="toggleCheck(this)">
                            <input type="checkbox">
                            RDB registration number confirmed
                        </li>
                        <li onclick="toggleCheck(this)">
                            <input type="checkbox">
                            TIN number verified with RRA
                        </li>
                        <li onclick="toggleCheck(this)">
                            <input type="checkbox">
                            Physical address confirmed
                        </li>
                        <li onclick="toggleCheck(this)">
                            <input type="checkbox">
                            No duplicate or fraudulent registration detected
                        </li>
                    </ul>

                    <label class="form-label">
                        Verification Note
                        <span style="font-weight:400;color:var(--slate-400);">(optional)</span>
                    </label>
                    <textarea name="verify_note"
                              class="form-control"
                              rows="2"
                              placeholder="Internal note for the audit log…"
                              style="font-size:.81rem;resize:none;"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-sm"
                            style="background:var(--slate-100);color:var(--slate-600);
                                   border:1px solid var(--slate-200);"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-patch-check-fill me-1"></i> Confirm Verification
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ── Reject Modal ─────────────────────────────────────────── --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="mh-danger">
                <div class="d-flex align-items-center gap-2">
                    <div class="mh-icon"><i class="bi bi-x-circle-fill"></i></div>
                    <div>
                        <p class="mh-title">Reject Employer</p>
                        <p class="mh-sub">This decision will be recorded in the audit log</p>
                    </div>
                </div>
                <button type="button"
                        class="btn-close btn-close-white ms-auto d-block mt-n3"
                        data-bs-dismiss="modal"></button>
            </div>

            <form method="POST"
                  action="{{ route('admin.employers.verify', $employer) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="action" value="reject">

                <div class="modal-body">

                    <div class="m-emp-card">
                        <div class="m-emp-logo">
                            {{ strtoupper(substr($employer->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="m-emp-name">{{ $employer->name }}</div>
                            <div class="m-emp-reg">
                                {{ $employer->registration_number ?? $employer->tin_number ?? '—' }}
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 p-3 rounded"
                         style="background:#FEF2F2;border:1px solid #FECACA;">
                        <div class="d-flex gap-2">
                            <i class="bi bi-exclamation-triangle-fill"
                               style="color:#DC2626;font-size:.82rem;margin-top:.1rem;"></i>
                            <p style="font-size:.77rem;color:#991B1B;margin:0;line-height:1.55;">
                                Rejecting this employer prevents them from reporting employment records.
                                They may re-apply with corrected documentation.
                            </p>
                        </div>
                    </div>

                    <label class="form-label">
                        Reason for Rejection <span class="text-danger">*</span>
                    </label>
                    <textarea name="rejection_reason"
                              class="form-control"
                              rows="4"
                              required
                              placeholder="e.g. RDB registration certificate could not be validated. Please resubmit with a certified copy…"
                              style="font-size:.81rem;resize:none;"></textarea>
                    <div class="form-text" style="font-size:.7rem;">
                        The employer will see this reason when they log in.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-sm"
                            style="background:var(--slate-100);color:var(--slate-600);
                                   border:1px solid var(--slate-200);"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-x-circle me-1"></i> Confirm Rejection
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ── Suspend Modal ────────────────────────────────────────── --}}
<div class="modal fade" id="suspendModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="mh-warning">
                <div class="d-flex align-items-center gap-2">
                    <div class="mh-icon"><i class="bi bi-pause-circle-fill"></i></div>
                    <div>
                        <p class="mh-title">Suspend Employer</p>
                        <p class="mh-sub">Temporarily restrict this organisation's registry access</p>
                    </div>
                </div>
                <button type="button"
                        class="btn-close btn-close-white ms-auto d-block mt-n3"
                        data-bs-dismiss="modal"></button>
            </div>

            <form method="POST"
                  action="{{ route('admin.employers.verify', $employer) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="action" value="suspend">

                <div class="modal-body">

                    <div class="m-emp-card">
                        <div class="m-emp-logo">
                            {{ strtoupper(substr($employer->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="m-emp-name">{{ $employer->name }}</div>
                            <div class="m-emp-reg">
                                {{ $employer->registration_number ?? $employer->tin_number ?? '—' }}
                            </div>
                        </div>
                        <span class="ms-auto ep-status eps-verified" style="font-size:.67rem;">
                            <i class="bi bi-patch-check-fill"></i> Verified
                        </span>
                    </div>

                    <label class="form-label">
                        Reason for Suspension <span class="text-danger">*</span>
                    </label>
                    <textarea name="suspension_reason"
                              class="form-control"
                              rows="3"
                              required
                              placeholder="Reason this employer is being suspended…"
                              style="font-size:.81rem;resize:none;"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-sm"
                            style="background:var(--slate-100);color:var(--slate-600);
                                   border:1px solid var(--slate-200);"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit"
                            class="btn btn-sm"
                            style="background:#D97706;border-color:#B45309;color:#fff;">
                        <i class="bi bi-pause-circle me-1"></i> Confirm Suspension
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>



<script>
// Tab switching
document.querySelectorAll('.ep-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.ep-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-pane-ep').forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        const panel = document.getElementById('tab-' + tab.dataset.tab);
        if (panel) panel.classList.add('active');
    });
});

// Checklist toggle
function toggleCheck(li) {
    const cb = li.querySelector('input[type=checkbox]');
    cb.checked = !cb.checked;
    li.classList.toggle('checked', cb.checked);
}

// Auto-dismiss flash alerts
setTimeout(() => {
    document.querySelectorAll('.flash-alert').forEach(el => {
        el.style.transition = 'opacity .4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 5000);
</script>
@endsection