{{-- resources/views/employees/_layout.blade.php --}}
{{-- This is a shared partial for the employees module header/styles --}}
{{-- Extend your app layout and @yield('content') inside --}}

{{-- ════════════════════════════════════════════════════
     NOTE: If your app already has a master layout, replace
     the <head> block below with @extends('layouts.app')
     and wrap content in @section('content').
     ════════════════════════════════════════════════════ --}}

<style>
/* ── Employee Module Design System ─────────────────── */
:root {
    --bg-deep:      #060f11;
    --bg-card:      #0c1a1e;
    --bg-input:     #0f2228;
    --bg-hover:     #132830;
    --border:       #1e3a42;
    --border-focus: #2dd4bf;
    --teal:         #2dd4bf;
    --teal-dim:     #1a8a7a;
    --teal-glow:    rgba(45,212,191,.15);
    --gold:         #f59e0b;
    --red:          #f43f5e;
    --red-dim:      rgba(244,63,94,.12);
    --muted:        #4b6e78;
    --text:         #e2eff2;
    --text-dim:     #7a9da8;
    --radius:       10px;
    --shadow:       0 4px 24px rgba(0,0,0,.5);
    --font-head:    'Syne', sans-serif;
    --font-body:    'DM Sans', sans-serif;
}

/* Base reset within module */
.em-wrap *, .em-wrap *::before, .em-wrap *::after { box-sizing: border-box; }

.em-wrap {
    font-family: var(--font-body);
    color: var(--text);
    background: var(--bg-deep);
    min-height: 100vh;
    padding: 2rem 1.5rem;
}

/* Typography */
.em-page-title {
    font-family: var(--font-head);
    font-size: 1.75rem;
    font-weight: 700;
    letter-spacing: -.02em;
    color: var(--text);
    margin: 0 0 .25rem;
}
.em-page-sub {
    font-size: .875rem;
    color: var(--text-dim);
    margin: 0 0 2rem;
}

/* Cards */
.em-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.75rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow);
}
.em-card-title {
    font-family: var(--font-head);
    font-size: 1rem;
    font-weight: 600;
    color: var(--teal);
    text-transform: uppercase;
    letter-spacing: .08em;
    margin: 0 0 1.25rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.em-card-title::before {
    content: '';
    display: inline-block;
    width: 3px;
    height: 1em;
    background: var(--teal);
    border-radius: 2px;
}

/* Form elements */
.em-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.25rem;
}
.em-form-full { grid-column: 1 / -1; }

.em-field { display: flex; flex-direction: column; gap: .4rem; }
.em-label {
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-dim);
    text-transform: uppercase;
    letter-spacing: .06em;
}
.em-label .req { color: var(--teal); margin-left: 2px; }

.em-input,
.em-select,
.em-textarea {
    background: var(--bg-input);
    border: 1px solid var(--border);
    border-radius: 7px;
    color: var(--text);
    font-family: var(--font-body);
    font-size: .9rem;
    padding: .65rem .9rem;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
    outline: none;
}
.em-input:focus,
.em-select:focus,
.em-textarea:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px var(--teal-glow);
}
.em-select option { background: var(--bg-card); }
.em-textarea { resize: vertical; min-height: 90px; }
.em-input::placeholder { color: var(--muted); }

.em-error {
    font-size: .78rem;
    color: var(--red);
    margin-top: .2rem;
}

/* Buttons */
.em-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .65rem 1.4rem;
    border-radius: 7px;
    font-family: var(--font-body);
    font-size: .875rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    line-height: 1;
}
.em-btn-primary {
    background: var(--teal);
    color: #060f11;
}
.em-btn-primary:hover { background: #38ede0; box-shadow: 0 0 16px var(--teal-glow); }

.em-btn-outline {
    background: transparent;
    color: var(--teal);
    border: 1px solid var(--teal);
}
.em-btn-outline:hover { background: var(--teal-glow); }

.em-btn-danger {
    background: var(--red-dim);
    color: var(--red);
    border: 1px solid var(--red);
}
.em-btn-danger:hover { background: rgba(244,63,94,.22); }

.em-btn-ghost {
    background: transparent;
    color: var(--text-dim);
    border: 1px solid var(--border);
}
.em-btn-ghost:hover { color: var(--text); border-color: var(--muted); }

/* Badges */
.em-badge {
    display: inline-block;
    padding: .2rem .6rem;
    border-radius: 4px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .05em;
    text-transform: uppercase;
}
.em-badge-active  { background: rgba(45,212,191,.15); color: var(--teal); }
.em-badge-closed  { background: rgba(122,157,168,.12); color: var(--text-dim); }
.em-badge-pending { background: rgba(245,158,11,.12); color: var(--gold); }
.em-badge-danger  { background: var(--red-dim); color: var(--red); }

/* Alerts */
.em-alert {
    padding: .85rem 1.1rem;
    border-radius: var(--radius);
    font-size: .875rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: .65rem;
}
.em-alert-success { background: rgba(45,212,191,.1); border: 1px solid rgba(45,212,191,.3); color: var(--teal); }
.em-alert-error   { background: var(--red-dim); border: 1px solid rgba(244,63,94,.3); color: var(--red); }
.em-alert-info    { background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.25); color: var(--gold); }

/* Table */
.em-table-wrap { overflow-x: auto; }
.em-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
}
.em-table th {
    text-align: left;
    padding: .7rem 1rem;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--text-dim);
    border-bottom: 1px solid var(--border);
}
.em-table td {
    padding: .85rem 1rem;
    border-bottom: 1px solid rgba(30,58,66,.5);
    color: var(--text);
    vertical-align: middle;
}
.em-table tr:hover td { background: var(--bg-hover); }
.em-table tr:last-child td { border-bottom: none; }

/* Profile grid */
.em-profile-grid {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 2rem;
    align-items: start;
}
@media (max-width: 700px) { .em-profile-grid { grid-template-columns: 1fr; } }

.em-avatar {
    width: 160px;
    height: 160px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid var(--border);
}
.em-avatar-placeholder {
    width: 160px;
    height: 160px;
    border-radius: 12px;
    background: var(--bg-input);
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-head);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--teal);
}

.em-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}
.em-meta-item {}
.em-meta-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--muted);
    margin-bottom: .2rem;
}
.em-meta-value { font-size: .925rem; color: var(--text); }

/* Divider */
.em-divider { border: none; border-top: 1px solid var(--border); margin: 1.5rem 0; }

/* Header row */
.em-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2rem;
}

/* Pagination */
.em-pagination { margin-top: 1.5rem; }
.em-pagination .pagination {
    display: flex;
    gap: .35rem;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}
.em-pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 .6rem;
    border-radius: 6px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    color: var(--text-dim);
    font-size: .85rem;
    text-decoration: none;
    transition: all .2s;
}
.em-pagination .page-link:hover { border-color: var(--teal); color: var(--teal); }
.em-pagination .active .page-link { background: var(--teal); color: #060f11; border-color: var(--teal); font-weight: 700; }
.em-pagination .disabled .page-link { opacity: .4; pointer-events: none; }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">