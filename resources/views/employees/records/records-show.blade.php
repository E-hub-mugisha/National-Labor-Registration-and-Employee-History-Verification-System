{{-- resources/views/employees/records/show.blade.php --}}
@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
:root {
    --ink:         #0f1117;
    --ink-2:       #343a52;
    --ink-3:       #6b7394;
    --line:        #e4e7f0;
    --bg:          #f6f7fb;
    --white:       #ffffff;
    --accent:      #2563eb;
    --accent-soft: #eff4ff;
    --accent-mid:  #bfcffe;
    --emerald:     #059669;
    --emerald-s:   #ecfdf5;
    --emerald-b:   #a7f3d0;
    --amber:       #d97706;
    --amber-s:     #fffbeb;
    --amber-b:     #fcd34d;
    --rose:        #e11d48;
    --rose-s:      #fff1f2;
    --rose-b:      #fecdd3;
    --sky:         #0284c7;
    --sky-s:       #f0f9ff;
    --sky-b:       #bae6fd;
    --orange:      #ea580c;
    --orange-s:    #fff7ed;
    --orange-b:    #fed7aa;
    --radius:      12px;
    --radius-sm:   8px;
    --shadow:      0 1px 3px rgba(15,17,23,.06), 0 4px 16px rgba(15,17,23,.06);
    --shadow-md:   0 4px 6px rgba(15,17,23,.05), 0 12px 36px rgba(15,17,23,.12);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Geist', sans-serif;
    background: var(--bg);
    color: var(--ink);
    -webkit-font-smoothing: antialiased;
}

/* ── Layout ───────────────────────────────── */
.wrap { max-width: 960px; margin: 0 auto; padding: 40px 24px 80px; }

/* ── Breadcrumb ───────────────────────────── */
.breadcrumb-row {
    display: flex; align-items: center; gap: 6px;
    font-size: 12.5px; color: var(--ink-3);
    margin-bottom: 28px; font-weight: 500;
}
.breadcrumb-row a { color: var(--ink-3); text-decoration: none; }
.breadcrumb-row a:hover { color: var(--accent); }
.breadcrumb-row .sep { color: var(--line); }
.breadcrumb-row .current { color: var(--ink-2); }

/* ── Hero card ────────────────────────────── */
.hero-card {
    background: var(--ink);
    border-radius: var(--radius);
    padding: 32px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    color: #fff;
}
.hero-card::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 70% at 90% 10%, rgba(37,99,235,.3) 0%, transparent 60%),
        radial-gradient(ellipse 40% 50% at 5% 95%, rgba(5,150,105,.15) 0%, transparent 55%);
    pointer-events: none;
}
.hero-inner {
    position: relative;
    display: grid;
    grid-template-columns: 60px 1fr auto;
    gap: 20px;
    align-items: center;
}
.hero-logo {
    width: 60px; height: 60px; border-radius: 14px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 20px; color: #fff;
    letter-spacing: -.5px; flex-shrink: 0;
}
.hero-employer {
    font-family: 'Instrument Serif', serif;
    font-size: 24px; line-height: 1.2;
    color: #fff; font-weight: 400;
}
.hero-position { font-size: 14px; color: rgba(255,255,255,.6); margin-top: 3px; }
.hero-meta {
    display: flex; flex-wrap: wrap; gap: 6px 16px;
    margin-top: 8px;
    font-size: 12.5px; color: rgba(255,255,255,.5);
}
.hero-meta span { display: flex; align-items: center; gap: 5px; }
.hero-badges { display: flex; flex-direction: column; gap: 7px; align-items: flex-end; }

.badge-pill {
    display: inline-flex; align-items: center; gap: 5px;
    border-radius: 999px; font-size: 11.5px; font-weight: 600;
    padding: 4px 11px; white-space: nowrap;
}
.bp-active    { background: var(--emerald-s); color: var(--emerald); border: 1px solid var(--emerald-b); }
.bp-ended     { background: var(--bg);        color: var(--ink-3);   border: 1px solid var(--line);      }
.bp-verified  { background: rgba(5,150,105,.2); color: #6ee7b7; border: 1px solid rgba(5,150,105,.3); }
.bp-pending   { background: rgba(217,119,6,.2);  color: #fcd34d;  border: 1px solid rgba(217,119,6,.3); }
.bp-excellent { background: var(--emerald-s); color: var(--emerald); border: 1px solid var(--emerald-b); }
.bp-good      { background: var(--sky-s);     color: var(--sky);     border: 1px solid var(--sky-b); }
.bp-satisfactory { background: var(--amber-s); color: var(--amber);  border: 1px solid var(--amber-b); }
.bp-poor      { background: var(--orange-s);  color: var(--orange);  border: 1px solid var(--orange-b); }
.bp-very_poor { background: var(--rose-s);    color: var(--rose);    border: 1px solid var(--rose-b); }
.bp-review    { background: var(--sky-s);     color: var(--sky);     border: 1px solid var(--sky-b); }
.bp-resolved  { background: var(--emerald-s); color: var(--emerald); border: 1px solid var(--emerald-b); }
.bp-rejected  { background: var(--rose-s);    color: var(--rose);    border: 1px solid var(--rose-b); }

/* ── Two-col layout ───────────────────────── */
.body-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 16px;
    align-items: start;
}

/* ── Panel ────────────────────────────────── */
.panel {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 16px;
}
.panel:last-child { margin-bottom: 0; }
.panel-head {
    padding: 16px 22px;
    border-bottom: 1px solid var(--line);
    display: flex; align-items: center; gap: 10px;
}
.panel-icon {
    width: 30px; height: 30px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
}
.pi-blue   { background: var(--accent-soft); color: var(--accent); }
.pi-green  { background: var(--emerald-s);   color: var(--emerald); }
.pi-amber  { background: var(--amber-s);     color: var(--amber); }
.pi-rose   { background: var(--rose-s);      color: var(--rose); }
.panel-title {
    font-weight: 600; font-size: 14px; color: var(--ink);
}
.panel-body { padding: 20px 22px; }

/* ── Detail grid ──────────────────────────── */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px 24px;
}
.detail-item {}
.detail-label {
    font-size: 11px; font-weight: 700;
    color: var(--ink-3);
    text-transform: uppercase; letter-spacing: .07em;
    margin-bottom: 5px;
}
.detail-val {
    font-size: 14px; font-weight: 500; color: var(--ink-2);
}
.detail-val.big {
    font-size: 16px; font-weight: 600; color: var(--ink);
}

/* Conduct remarks block */
.remarks-block {
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    font-size: 13.5px; color: var(--ink-2);
    line-height: 1.6;
    font-style: italic;
}

/* Rehire chip */
.rehire-yes { color: var(--emerald); font-weight: 600; }
.rehire-no  { color: var(--rose);    font-weight: 600; }

/* ── Flash ────────────────────────────────── */
.flash {
    display: flex; align-items: center; gap: 10px;
    border-radius: var(--radius-sm);
    padding: 13px 16px; margin-bottom: 16px;
    font-size: 14px; font-weight: 500;
    animation: slideDown .3s ease;
}
.flash-success { background: var(--emerald-s); border: 1px solid var(--emerald-b); color: var(--emerald); }
.flash-error   { background: var(--rose-s);    border: 1px solid var(--rose-b);    color: var(--rose); }
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Claim button (sidebar) ───────────────── */
.btn-claim-main {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%;
    background: linear-gradient(135deg, var(--rose), #be123c);
    color: #fff; border: none;
    border-radius: var(--radius-sm);
    font-size: 14px; font-weight: 600;
    padding: 11px 20px;
    cursor: pointer;
    font-family: inherit;
    box-shadow: 0 4px 14px rgba(225,29,72,.25);
    transition: opacity .15s, transform .15s;
}
.btn-claim-main:hover { opacity: .9; transform: translateY(-1px); }

.btn-accept-main {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%;
    background: var(--emerald-s);
    color: var(--emerald);
    border: 1px solid var(--emerald-b);
    border-radius: var(--radius-sm);
    font-size: 14px; font-weight: 600;
    padding: 11px 20px;
    cursor: pointer;
    font-family: inherit;
    transition: background .15s;
    margin-bottom: 10px;
}
.btn-accept-main:hover { background: #d1fae5; }

/* ── Claims history ───────────────────────── */
.claim-item {
    padding: 14px 0;
    border-bottom: 1px solid var(--line);
}
.claim-item:last-child { border-bottom: none; padding-bottom: 0; }
.claim-item:first-child { padding-top: 0; }
.claim-type-label { font-size: 13.5px; font-weight: 600; color: var(--ink); }
.claim-date       { font-size: 11.5px; color: var(--ink-3); margin-top: 2px; }
.claim-desc       {
    font-size: 13px; color: var(--ink-3);
    margin-top: 6px; line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.claim-response {
    margin-top: 8px;
    background: var(--bg); border: 1px solid var(--line);
    border-radius: 6px; padding: 8px 12px;
    font-size: 12.5px; color: var(--ink-3);
    border-left: 3px solid var(--accent);
}
.claim-response-label { font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: var(--accent); margin-bottom: 2px; }

/* ── Modal ────────────────────────────────── */
.modal-content {
    border: none;
    border-radius: 18px;
    box-shadow: var(--shadow-md);
    font-family: 'Geist', sans-serif;
}
.modal-header {
    border-bottom: 1px solid var(--line);
    padding: 22px 26px 18px;
    border-radius: 18px 18px 0 0;
}
.modal-title-wrap { display: flex; align-items: center; gap: 12px; }
.modal-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: var(--rose-s); border: 1px solid var(--rose-b);
    display: flex; align-items: center; justify-content: center;
    color: var(--rose); font-size: 17px; flex-shrink: 0;
}
.modal-title   { font-family: 'Instrument Serif', serif; font-size: 19px; font-weight: 400; color: var(--ink); margin: 0; }
.modal-subtitle { font-size: 12px; color: var(--ink-3); margin: 2px 0 0; }
.modal-body    { padding: 22px 26px; background: var(--bg); }
.modal-footer  {
    background: var(--white); border-top: 1px solid var(--line);
    padding: 16px 26px; border-radius: 0 0 18px 18px;
    display: flex; justify-content: flex-end; gap: 10px;
}

.form-label {
    font-size: 11.5px; font-weight: 700;
    color: var(--ink-3);
    text-transform: uppercase; letter-spacing: .06em;
    margin-bottom: 6px; display: block;
}
.form-control, .form-select {
    border: 1px solid var(--line);
    border-radius: var(--radius-sm);
    font-size: 14px;
    font-family: 'Geist', sans-serif;
    padding: 9px 13px;
    color: var(--ink);
    background: var(--white);
    transition: border-color .15s, box-shadow .15s;
    width: 100%;
}
.form-control:focus, .form-select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}
textarea.form-control { resize: vertical; min-height: 108px; }

.file-zone {
    border: 2px dashed var(--line);
    border-radius: var(--radius-sm);
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    background: var(--white);
}
.file-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
.file-zone input[type=file] { display: none; }
.file-zone-icon  { font-size: 24px; color: var(--line); display: block; margin-bottom: 6px; }
.file-zone-label { font-size: 13px; color: var(--ink-3); cursor: pointer; display: block; }

.btn-cancel {
    background: var(--white); border: 1px solid var(--line);
    border-radius: var(--radius-sm); color: var(--ink-3);
    font-size: 14px; font-weight: 600;
    padding: 9px 20px; font-family: inherit;
    cursor: pointer; transition: background .15s;
}
.btn-cancel:hover { background: var(--bg); }
.btn-submit {
    background: linear-gradient(135deg, var(--rose), #be123c);
    border: none; border-radius: var(--radius-sm);
    color: #fff; font-size: 14px; font-weight: 600;
    padding: 9px 22px; font-family: inherit;
    box-shadow: 0 4px 12px rgba(225,29,72,.25);
    cursor: pointer;
    display: inline-flex; align-items: center; gap: 7px;
    transition: opacity .15s, transform .15s;
}
.btn-submit:hover { opacity: .9; transform: translateY(-1px); }

.error-box {
    background: var(--rose-s); border: 1px solid var(--rose-b);
    border-radius: var(--radius-sm); padding: 12px 14px;
    margin-bottom: 16px; font-size: 13px; color: var(--rose);
}
.error-box li { list-style: none; margin: 2px 0; }
.error-box li::before { content: '· '; font-weight: 700; }

/* ── Back button ──────────────────────────── */
.btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 500; color: var(--ink-3);
    text-decoration: none;
    border: 1px solid var(--line);
    border-radius: var(--radius-sm);
    padding: 6px 13px;
    background: var(--white);
    transition: background .15s, color .15s;
    margin-bottom: 20px;
}
.btn-back:hover { background: var(--bg); color: var(--ink); }

/* ── Responsive ───────────────────────────── */
@media (max-width: 768px) {
    .body-grid { grid-template-columns: 1fr; }
    .hero-inner { grid-template-columns: 56px 1fr; }
    .hero-badges { flex-direction: row; grid-column: 1/-1; justify-content: flex-start; }
    .detail-grid { grid-template-columns: 1fr; }
    .wrap { padding: 24px 16px 60px; }
}
</style>
@endpush

@section('content')
<div class="wrap">

    {{-- Back button --}}
    <a href="{{ route('employee.records.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> All Records
    </a>

    {{-- Flash --}}
    @if(session('success'))
        <div class="flash flash-success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- ── Hero Card ──────────────────────────────────────── --}}
    @php
        $initials = strtoupper(substr($record->employer->name ?? '?', 0, 2));
        $conductMap = [
            'excellent'    => ['class' => 'bp-excellent', 'label' => 'Excellent'],
            'good'         => ['class' => 'bp-good',      'label' => 'Good'],
            'satisfactory' => ['class' => 'bp-satisfactory','label'=> 'Satisfactory'],
            'poor'         => ['class' => 'bp-poor',      'label' => 'Poor'],
            'very_poor'    => ['class' => 'bp-very_poor', 'label' => 'Very Poor'],
        ];
        $conduct = $conductMap[$record->conduct_rating] ?? null;
    @endphp

    <div class="hero-card">
        <div class="hero-inner">
            <div class="hero-logo">{{ $initials }}</div>
            <div>
                <div class="hero-employer">{{ $record->employer->name ?? 'Unknown Employer' }}</div>
                <div class="hero-position">{{ $record->position }}@if($record->department) &middot; {{ $record->department }}@endif</div>
                <div class="hero-meta">
                    <span>
                        <i class="bi bi-calendar3"></i>
                        {{ $record->start_date->format('d M Y') }}
                        →
                        {{ $record->end_date ? $record->end_date->format('d M Y') : 'Present' }}
                    </span>
                    <span>
                        <i class="bi bi-clock"></i>
                        {{ $record->duration }}
                    </span>
                    @if($record->salary)
                        <span>
                            <i class="bi bi-cash"></i>
                            {{ number_format($record->salary, 2) }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="hero-badges">
                @if($record->is_active)
                    <span class="badge-pill" style="background:rgba(5,150,105,.2);color:#6ee7b7;border:1px solid rgba(5,150,105,.3)">
                        <i class="bi bi-circle-fill" style="font-size:6px"></i> Active
                    </span>
                @else
                    <span class="badge-pill" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.12)">
                        <i class="bi bi-circle" style="font-size:8px"></i> Ended
                    </span>
                @endif
                @if($record->employee_verified)
                    <span class="badge-pill bp-verified">
                        <i class="bi bi-shield-fill-check" style="font-size:10px"></i> Verified
                    </span>
                @else
                    <span class="badge-pill bp-pending">
                        <i class="bi bi-clock" style="font-size:10px"></i> Unverified
                    </span>
                @endif
                @if($conduct)
                    <span class="badge-pill {{ $conduct['class'] }}">
                        <i class="bi bi-star-fill" style="font-size:9px"></i> {{ $conduct['label'] }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Body Grid ───────────────────────────────────────── --}}
    <div class="body-grid">

        {{-- LEFT: Details ─────────────────────────────────── --}}
        <div>

            {{-- Employment Details --}}
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-icon pi-blue"><i class="bi bi-briefcase"></i></div>
                    <span class="panel-title">Employment Details</span>
                </div>
                <div class="panel-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Position</div>
                            <div class="detail-val big">{{ $record->position }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Department</div>
                            <div class="detail-val">{{ $record->department ?? '—' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Start Date</div>
                            <div class="detail-val">{{ $record->start_date->format('d F Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">End Date</div>
                            <div class="detail-val">
                                @if($record->end_date)
                                    {{ $record->end_date->format('d F Y') }}
                                @else
                                    <span class="badge-pill bp-active" style="font-size:11px;padding:2px 9px">
                                        <i class="bi bi-circle-fill" style="font-size:6px"></i> Currently Active
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Duration</div>
                            <div class="detail-val">{{ $record->duration }}</div>
                        </div>
                        @if($record->salary)
                        <div class="detail-item">
                            <div class="detail-label">Salary</div>
                            <div class="detail-val">{{ number_format($record->salary, 2) }}</div>
                        </div>
                        @endif
                        <div class="detail-item">
                            <div class="detail-label">Eligible for Rehire</div>
                            <div class="detail-val">
                                @if(is_null($record->eligible_for_rehire))
                                    <span style="color:var(--ink-3)">—</span>
                                @elseif($record->eligible_for_rehire)
                                    <span class="rehire-yes"><i class="bi bi-check-circle-fill me-1"></i>Yes</span>
                                @else
                                    <span class="rehire-no"><i class="bi bi-x-circle-fill me-1"></i>No</span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Record Status</div>
                            <div class="detail-val">
                                @if($record->employee_verified)
                                    <span class="badge-pill bp-verified">
                                        <i class="bi bi-shield-fill-check" style="font-size:10px"></i> Employee Verified
                                    </span>
                                @else
                                    <span class="badge-pill bp-pending">
                                        <i class="bi bi-clock" style="font-size:10px"></i> Awaiting Verification
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Exit Information --}}
            @if(!$record->is_active)
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-icon pi-amber"><i class="bi bi-box-arrow-right"></i></div>
                    <span class="panel-title">Exit Information</span>
                </div>
                <div class="panel-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Exit Reason</div>
                            <div class="detail-val big">{{ $record->exitReasonLabel }}</div>
                        </div>
                        @if($record->exit_details)
                        <div class="detail-item" style="grid-column:1/-1">
                            <div class="detail-label">Exit Details</div>
                            <div class="detail-val">{{ $record->exit_details }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Conduct & Performance --}}
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-icon pi-green"><i class="bi bi-star"></i></div>
                    <span class="panel-title">Conduct &amp; Performance</span>
                </div>
                <div class="panel-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Conduct Rating</div>
                            <div class="detail-val">
                                @if($conduct)
                                    <span class="badge-pill {{ $conduct['class'] }}">
                                        <i class="bi bi-star-fill" style="font-size:9px"></i>
                                        {{ $conduct['label'] }}
                                    </span>
                                @else
                                    <span style="color:var(--ink-3)">Not rated</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($record->conduct_remarks)
                        <div style="margin-top:16px">
                            <div class="detail-label" style="margin-bottom:8px">Conduct Remarks</div>
                            <div class="remarks-block">"{{ $record->conduct_remarks }}"</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Claims History --}}
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-icon pi-rose"><i class="bi bi-flag"></i></div>
                    <span class="panel-title">Claims on This Record</span>
                    @if($record->claims->count() > 0)
                        <span class="badge-pill bp-rejected ms-auto" style="font-size:11px;padding:2px 9px">
                            {{ $record->claims->count() }} claim{{ $record->claims->count() > 1 ? 's' : '' }}
                        </span>
                    @endif
                </div>
                <div class="panel-body">
                    @if($record->claims->isEmpty())
                        <div style="text-align:center;padding:20px 0;color:var(--ink-3);font-size:13.5px;">
                            <i class="bi bi-flag" style="font-size:22px;display:block;margin-bottom:8px;opacity:.3"></i>
                            No claims filed on this record.
                        </div>
                    @else
                        @foreach($record->claims as $claim)
                            @php
                                $statusMap = [
                                    'pending'      => ['class' => 'bp-pending',  'icon' => 'bi-clock',       'label' => 'Pending'],
                                    'under_review' => ['class' => 'bp-review',   'icon' => 'bi-search',      'label' => 'Under Review'],
                                    'resolved'     => ['class' => 'bp-resolved', 'icon' => 'bi-check-circle','label' => 'Resolved'],
                                    'rejected'     => ['class' => 'bp-rejected', 'icon' => 'bi-x-circle',    'label' => 'Rejected'],
                                ];
                                $cs = $statusMap[$claim->status] ?? ['class'=>'bp-pending','icon'=>'bi-clock','label'=>ucfirst($claim->status)];
                            @endphp
                            <div class="claim-item">
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap">
                                    <span class="claim-type-label">{{ $claim->claimTypeLabel }}</span>
                                    <span class="badge-pill {{ $cs['class'] }}" style="font-size:11px;padding:2px 9px">
                                        <i class="bi {{ $cs['icon'] }}" style="font-size:10px"></i>
                                        {{ $cs['label'] }}
                                    </span>
                                </div>
                                <div class="claim-date">Filed {{ $claim->created_at->format('d M Y') }}</div>
                                <div class="claim-desc">{{ $claim->description }}</div>
                                @if($claim->admin_note || $claim->employer_response)
                                    <div class="claim-response">
                                        <div class="claim-response-label">Response</div>
                                        {{ $claim->admin_note ?? $claim->employer_response }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT: Sidebar ────────────────────────────────── --}}
        <div>

            {{-- Actions --}}
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-icon pi-blue"><i class="bi bi-lightning"></i></div>
                    <span class="panel-title">Actions</span>
                </div>
                <div class="panel-body">
                    @if(!$record->employee_verified)
                        <form method="POST" action="{{ route('employee.record.accept') }}" class="mb-2">
                            @csrf
                            <input type="hidden" name="employment_record_id" value="{{ $record->id }}">
                            <button type="submit" class="btn-accept-main">
                                <i class="bi bi-shield-check"></i> Verify This Record
                            </button>
                        </form>
                    @endif

                    <button type="button" class="btn-claim-main" data-bs-toggle="modal" data-bs-target="#claimModal">
                        <i class="bi bi-flag"></i> File a Claim
                    </button>

                    <p style="font-size:12px;color:var(--ink-3);margin-top:10px;line-height:1.5;text-align:center;">
                        Dispute incorrect information on this employment record.
                    </p>
                </div>
            </div>

            {{-- Record Info --}}
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-icon pi-blue"><i class="bi bi-info-circle"></i></div>
                    <span class="panel-title">Record Info</span>
                </div>
                <div class="panel-body">
                    <div style="display:flex;flex-direction:column;gap:14px">
                        <div>
                            <div class="detail-label">Record ID</div>
                            <div class="detail-val" style="font-family:monospace;font-size:13px">#{{ str_pad($record->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div>
                            <div class="detail-label">Created</div>
                            <div class="detail-val">{{ $record->created_at->format('d M Y') }}</div>
                        </div>
                        <div>
                            <div class="detail-label">Last Updated</div>
                            <div class="detail-val">{{ $record->updated_at->diffForHumans() }}</div>
                        </div>
                        @if($record->recordedBy)
                        <div>
                            <div class="detail-label">Recorded By</div>
                            <div class="detail-val">{{ $record->recordedBy->name }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════ --}}
{{-- CLAIM MODAL                                        --}}
{{-- ══════════════════════════════════════════════════ --}}
<div class="modal fade" id="claimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:530px">
        <div class="modal-content">

            <div class="modal-header">
                <div class="modal-title-wrap">
                    <div class="modal-icon"><i class="bi bi-flag-fill"></i></div>
                    <div>
                        <div class="modal-title">File a Claim</div>
                        <div class="modal-subtitle">
                            {{ $record->employer->name ?? 'Unknown' }} &middot; {{ $record->position }}
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @if($errors->any())
                    <ul class="error-box">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST"
                      action="{{ route('employee.claim.store') }}"
                      enctype="multipart/form-data"
                      id="claimForm">
                    @csrf
                    <input type="hidden" name="employment_record_id" value="{{ $record->id }}">

                    <div class="mb-3">
                        <label class="form-label">Issue Type</label>
                        <select name="claim_type" class="form-select" required>
                            <option value="" disabled selected>Select the type of dispute…</option>
                            <option value="wrong_dates"          {{ old('claim_type') === 'wrong_dates'          ? 'selected' : '' }}>Incorrect Employment Dates</option>
                            <option value="wrong_position"       {{ old('claim_type') === 'wrong_position'       ? 'selected' : '' }}>Incorrect Position / Title</option>
                            <option value="wrong_exit_reason"    {{ old('claim_type') === 'wrong_exit_reason'    ? 'selected' : '' }}>Incorrect Exit Reason</option>
                            <option value="wrong_conduct_rating" {{ old('claim_type') === 'wrong_conduct_rating' ? 'selected' : '' }}>Incorrect Conduct Rating</option>
                            <option value="wrong_remarks"        {{ old('claim_type') === 'wrong_remarks'        ? 'selected' : '' }}>Incorrect Conduct Remarks</option>
                            <option value="other"                {{ old('claim_type') === 'other'                ? 'selected' : '' }}>Other Dispute</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  placeholder="Describe exactly what is incorrect and what the correct information should be…"
                                  required>{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="form-label">
                            Evidence
                            <span style="color:var(--ink-3);font-weight:400;text-transform:none;letter-spacing:0"> — optional</span>
                        </label>
                        <div class="file-zone" onclick="document.getElementById('evidence_file').click()">
                            <i class="bi bi-cloud-arrow-up file-zone-icon"></i>
                            <span class="file-zone-label" id="fileLabel">
                                Click to upload &nbsp;·&nbsp; PDF, JPG or PNG, max 2 MB
                            </span>
                            <input type="file" id="evidence_file" name="evidence_file"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   onchange="updateLabel(this)">
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="claimForm" class="btn-submit">
                    <i class="bi bi-send"></i> Submit Claim
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateLabel(input) {
        document.getElementById('fileLabel').textContent =
            input.files[0] ? '📎 ' + input.files[0].name : 'Click to upload · PDF, JPG or PNG, max 2 MB';
    }

    // Re-open modal if validation failed
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            new bootstrap.Modal(document.getElementById('claimModal')).show();
        });
    @endif
</script>
@endpush
