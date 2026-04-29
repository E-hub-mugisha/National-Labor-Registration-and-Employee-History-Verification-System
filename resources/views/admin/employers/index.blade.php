@extends('layouts.app')
@section('title', 'Employers')


@section('content')
<style>
    /* ── Page-level overrides ───────────────────────────── */
    .employers-header {
        background: linear-gradient(135deg, var(--navy-800) 0%, var(--navy-600) 100%);
        border-radius: var(--radius-lg);
        padding: 1.6rem 1.75rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .employers-header::before {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,.04);
        pointer-events: none;
    }

    .employers-header::after {
        content: '';
        position: absolute;
        right: 60px;
        bottom: -60px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(0,158,79,.08);
        pointer-events: none;
    }

    .employers-header h4 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #fff;
        margin: 0 0 .2rem;
    }

    .employers-header p {
        font-size: .8rem;
        color: rgba(255,255,255,.55);
        margin: 0;
    }

    /* Summary pills */
    .summary-pills {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
        margin-top: 1.1rem;
    }

    .summary-pill {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .35rem .9rem;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .02em;
    }

    .pill-total   { background: rgba(255,255,255,.12); color: rgba(255,255,255,.9); }
    .pill-verified{ background: rgba(0,158,79,.25);    color: #6EE7A8; }
    .pill-pending { background: rgba(245,158,11,.2);   color: #FCD34D; }
    .pill-rejected{ background: rgba(220,38,38,.2);    color: #FCA5A5; }

    /* Filter bar */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .75rem;
        padding: .9rem 1.1rem;
        background: #fff;
        border: 1px solid var(--slate-200);
        border-radius: var(--radius-md);
        margin-bottom: 1rem;
    }

    .filter-bar .form-control,
    .filter-bar .form-select {
        height: 36px;
        font-size: .8rem;
        padding: .3rem .7rem;
    }

    .filter-bar .input-group-text {
        background: var(--slate-50);
        border-color: var(--slate-200);
        color: var(--slate-400);
        font-size: .85rem;
    }

    /* Company avatar */
    .company-avatar {
        width: 38px;
        height: 38px;
        border-radius: var(--radius-sm);
        background: linear-gradient(135deg, var(--navy-700), var(--navy-500));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .85rem;
        font-weight: 800;
        color: rgba(255,255,255,.9);
        flex-shrink: 0;
        letter-spacing: .02em;
    }

    /* Table enhancements */
    .employer-table thead th {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--slate-400);
        background: var(--slate-50);
        border-bottom: 1px solid var(--slate-200);
        padding: .7rem 1rem;
        white-space: nowrap;
    }

    .employer-table tbody td {
        padding: .8rem 1rem;
        border-bottom: 1px solid var(--slate-100);
        vertical-align: middle;
        font-size: .83rem;
    }

    .employer-table tbody tr:last-child td { border-bottom: none; }

    .employer-table tbody tr {
        transition: background .12s ease;
    }

    .employer-table tbody tr:hover td {
        background: #F8FAFF;
    }

    /* Company name */
    .company-name {
        font-weight: 700;
        font-size: .85rem;
        color: var(--slate-800);
        line-height: 1.3;
    }

    .company-email {
        font-size: .73rem;
        color: var(--slate-400);
        margin-top: 1px;
    }

    /* Code pill */
    .code-pill {
        display: inline-block;
        background: var(--slate-100);
        color: var(--navy-700);
        font-family: 'DM Mono', monospace;
        font-size: .72rem;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 4px;
        letter-spacing: .03em;
    }

    /* Sector tag */
    .sector-tag {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        background: var(--blue-100);
        color: var(--navy-600);
        font-size: .71rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 4px;
    }

    /* District */
    .district-text {
        font-size: .8rem;
        color: var(--slate-600);
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* Status badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .03em;
        white-space: nowrap;
    }

    .status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-verified  { background: #D1FAE5; color: #065F46; }
    .status-verified .dot  { background: #059669; }

    .status-pending   { background: #FEF3C7; color: #92400E; }
    .status-pending .dot   { background: #D97706; animation: pulse 1.8s infinite; }

    .status-rejected  { background: #FEE2E2; color: #991B1B; }
    .status-rejected .dot  { background: #DC2626; }

    .status-suspended { background: #F1F5F9; color: #475569; }
    .status-suspended .dot { background: #94A3B8; }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%       { opacity: .3; }
    }

    /* Action buttons */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: var(--radius-sm);
        font-size: .8rem;
        transition: var(--transition);
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-approve {
        background: #D1FAE5;
        color: #065F46;
        border-color: #A7F3D0;
    }

    .btn-approve:hover {
        background: var(--green-500);
        color: #fff;
        border-color: var(--green-500);
    }

    .btn-reject {
        background: #FEE2E2;
        color: #991B1B;
        border-color: #FECACA;
    }

    .btn-reject:hover {
        background: var(--red-500);
        color: #fff;
        border-color: var(--red-500);
    }

    .btn-view {
        background: var(--blue-100);
        color: var(--navy-600);
        border-color: #BFDBFE;
    }

    .btn-view:hover {
        background: var(--navy-600);
        color: #fff;
        border-color: var(--navy-600);
    }

    /* Empty state */
    .empty-state {
        padding: 3.5rem 1.5rem;
        text-align: center;
    }

    .empty-state-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--slate-100);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: var(--slate-400);
        margin: 0 auto 1rem;
    }

    /* Modal polish */
    .modal-content {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
    }

    .modal-header {
        border-bottom: 1px solid var(--slate-200);
        padding: 1.1rem 1.25rem;
    }

    .modal-header .modal-title {
        font-size: .9rem;
        font-weight: 700;
        color: var(--slate-800);
    }

    .modal-body { padding: 1.25rem; }
    .modal-footer {
        border-top: 1px solid var(--slate-200);
        padding: .9rem 1.25rem;
    }

    /* Pagination override */
    .pagination .page-link {
        font-size: .78rem;
        color: var(--navy-600);
        border-color: var(--slate-200);
    }

    .pagination .page-item.active .page-link {
        background: var(--navy-600);
        border-color: var(--navy-600);
    }
</style>


{{-- ══ Page Header ══════════════════════════════════════════ --}}
<div class="employers-header">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
            <h4><i class="bi bi-building me-2 opacity-75"></i>Registered Employers</h4>
            <p>All organizations in the National Labor Registry of Rwanda</p>
            <div class="summary-pills">
                <span class="summary-pill pill-total">
                    <i class="bi bi-layers-half"></i>
                    {{ $employers->total() }} Total
                </span>
                <span class="summary-pill pill-verified">
                    <i class="bi bi-patch-check-fill"></i>
                    {{ $employers->where('status','verified')->count() }} Verified
                </span>
                <span class="summary-pill pill-pending">
                    <i class="bi bi-hourglass-split"></i>
                    {{ $employers->where('status','pending')->count() }} Pending
                </span>
                <span class="summary-pill pill-rejected">
                    <i class="bi bi-x-circle"></i>
                    {{ $employers->where('status','rejected')->count() }} Rejected
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ══ Filter Bar ═══════════════════════════════════════════ --}}
<div class="filter-bar">
    <div class="input-group" style="max-width:260px;">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text"
               class="form-control"
               id="tableSearch"
               placeholder="Search company, RDB…">
    </div>

    <select class="form-select" id="statusFilter" style="max-width:160px;">
        <option value="">All Statuses</option>
        <option value="verified">Verified</option>
        <option value="pending">Pending</option>
        <option value="rejected">Rejected</option>
        <option value="suspended">Suspended</option>
    </select>

    <select class="form-select" id="sectorFilter" style="max-width:180px;">
        <option value="">All Sectors</option>
        @foreach([
            'Technology','Healthcare','Education','Banking & Finance',
            'Manufacturing','Construction','Agriculture','NGO / Non-Profit',
            'Hospitality & Tourism','Retail','BPO / Call Center','Public Administration'
        ] as $s)
            <option value="{{ $s }}">{{ $s }}</option>
        @endforeach
    </select>

    <span class="ms-auto text-muted" style="font-size:.75rem;" id="rowCount">
        Showing {{ $employers->count() }} of {{ $employers->total() }}
    </span>
</div>

{{-- ══ Table Card ═══════════════════════════════════════════ --}}
<div class="card" style="border-radius: var(--radius-lg); overflow:hidden;">
    <div class="table-responsive">
        <table class="table employer-table mb-0" id="employerTable">
            <thead>
                <tr>
                    <th class="ps-3" style="width:28%">Company</th>
                    <th style="width:13%">Reg. Number</th>
                    <th style="width:14%">Sector</th>
                    <th style="width:11%">District</th>
                    <th style="width:11%">Status</th>
                    <th style="width:10%">Joined</th>
                    <th style="width:13%" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employers as $employer)
                <tr data-status="{{ $employer->status }}"
                    data-sector="{{ $employer->sector_label }}">

                    {{-- Company --}}
                    <td class="ps-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="company-avatar">
                                {{ strtoupper(substr($employer->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="company-name">{{ $employer->name }}</div>
                                <div class="company-email">{{ $employer->user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Reg Number --}}
                    <td>
                        <span class="code-pill">{{ $employer->registration_number ?? $employer->tin_number ?? '—' }}</span>
                    </td>

                    {{-- Sector --}}
                    <td>
                        <span class="sector-tag">
                            <i class="bi bi-grid-3x3-gap"></i>
                            {{ $employer->sector_label }}
                        </span>
                    </td>

                    {{-- District --}}
                    <td>
                        <span class="district-text">
                            <i class="bi bi-geo-alt" style="color:var(--slate-400);font-size:.8rem;"></i>
                            {{ $employer->district }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        @php
                            $s = $employer->status;
                            $map = [
                                'verified'  => ['label' => 'Verified',  'cls' => 'status-verified'],
                                'pending'   => ['label' => 'Pending',   'cls' => 'status-pending'],
                                'rejected'  => ['label' => 'Rejected',  'cls' => 'status-rejected'],
                                'suspended' => ['label' => 'Suspended', 'cls' => 'status-suspended'],
                            ];
                            $info = $map[$s] ?? ['label' => ucfirst($s), 'cls' => 'status-suspended'];
                        @endphp
                        <span class="status-badge {{ $info['cls'] }}">
                            <span class="dot"></span>
                            {{ $info['label'] }}
                        </span>
                    </td>

                    {{-- Joined --}}
                    <td>
                        <div style="font-size:.8rem; color:var(--slate-600);">
                            {{ $employer->created_at->format('d M Y') }}
                        </div>
                        <div style="font-size:.7rem; color:var(--slate-400);">
                            {{ $employer->created_at->diffForHumans() }}
                        </div>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="d-flex align-items-center justify-content-center gap-1">

                            {{-- View (always visible) --}}
                            <a href="{{ route('admin.employers.show', $employer) }}" class="btn-action btn-view" title="View profile">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if($employer->status === 'pending')

                                {{-- Approve --}}
                                <form method="POST"
                                      action="{{ route('admin.employers.verify', $employer) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="verify">
                                    <button type="submit"
                                            class="btn-action btn-approve"
                                            title="Approve employer"
                                            onclick="return confirm('Approve {{ addslashes($employer->name) }}?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>

                                {{-- Reject (opens modal) --}}
                                <button class="btn-action btn-reject"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $employer->id }}"
                                        title="Reject employer">
                                    <i class="bi bi-x-lg"></i>
                                </button>

                            @elseif($employer->status === 'verified')

                                {{-- Suspend --}}
                                <form method="POST"
                                      action="{{ route('admin.employers.verify', $employer) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="suspend">
                                    <button type="submit"
                                            class="btn-action"
                                            style="background:#FEF3C7;color:#92400E;border-color:#FDE68A;"
                                            title="Suspend employer"
                                            onclick="return confirm('Suspend {{ addslashes($employer->name) }}?')">
                                        <i class="bi bi-pause-circle"></i>
                                    </button>
                                </form>

                            @endif
                        </div>
                    </td>
                </tr>

                {{-- Reject Modal ─────────────────────────────── --}}
                @if($employer->status === 'pending')
                <div class="modal fade"
                     id="rejectModal{{ $employer->id }}"
                     tabindex="-1"
                     aria-labelledby="rejectLabel{{ $employer->id }}"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:32px;height:32px;border-radius:6px;background:#FEE2E2;display:flex;align-items:center;justify-content:center;color:#DC2626;">
                                        <i class="bi bi-x-circle-fill" style="font-size:.9rem;"></i>
                                    </div>
                                    <div>
                                        <div class="modal-title" id="rejectLabel{{ $employer->id }}">
                                            Reject Employer
                                        </div>
                                        <div style="font-size:.72rem;color:var(--slate-400);margin-top:1px;">
                                            {{ $employer->name }}
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="POST"
                                  action="{{ route('admin.employers.verify', $employer) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="reject">

                                <div class="modal-body">
                                    <div class="mb-3 p-3 rounded"
                                         style="background:var(--slate-50);border:1px solid var(--slate-200);">
                                        <div class="d-flex gap-2 align-items-start">
                                            <i class="bi bi-info-circle text-primary mt-1" style="font-size:.85rem;"></i>
                                            <p class="mb-0" style="font-size:.78rem;color:var(--slate-600);">
                                                The employer will be notified of this decision.
                                                Provide a clear reason to help them re-apply correctly.
                                            </p>
                                        </div>
                                    </div>

                                    <label class="form-label">
                                        Reason for Rejection
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="rejection_reason"
                                              class="form-control"
                                              rows="4"
                                              required
                                              placeholder="e.g. RDB registration number could not be verified. Please resubmit with a valid certificate…"
                                              style="font-size:.82rem; resize:none;"></textarea>
                                    <div class="form-text" style="font-size:.72rem;">
                                        Minimum 20 characters recommended.
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-sm"
                                            style="background:var(--slate-100);color:var(--slate-600);border:1px solid var(--slate-200);"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Confirm Rejection
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                @endif

                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-building-slash"></i>
                            </div>
                            <div style="font-weight:700;font-size:.95rem;color:var(--slate-800);margin-bottom:.35rem;">
                                No employers found
                            </div>
                            <div style="font-size:.8rem;color:var(--slate-400);">
                                No organizations have registered in the system yet.
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($employers->hasPages())
    <div class="card-footer bg-white d-flex align-items-center justify-content-between flex-wrap gap-2"
         style="padding:.9rem 1.1rem; border-top:1px solid var(--slate-100);">
        <div style="font-size:.78rem;color:var(--slate-400);">
            Showing
            <strong style="color:var(--slate-600);">{{ $employers->firstItem() }}–{{ $employers->lastItem() }}</strong>
            of
            <strong style="color:var(--slate-600);">{{ $employers->total() }}</strong>
            employers
        </div>
        {{ $employers->links() }}
    </div>
    @endif
</div>



<script>
    // Live filter (client-side, works alongside server pagination for current page)
    const searchInput  = document.getElementById('tableSearch');
    const statusFilter = document.getElementById('statusFilter');
    const sectorFilter = document.getElementById('sectorFilter');
    const rows         = document.querySelectorAll('#employerTable tbody tr[data-status]');
    const rowCountEl   = document.getElementById('rowCount');

    function applyFilters() {
        const q      = searchInput.value.toLowerCase().trim();
        const status = statusFilter.value.toLowerCase();
        const sector = sectorFilter.value.toLowerCase();
        let visible  = 0;

        rows.forEach(row => {
            const text   = row.innerText.toLowerCase();
            const rStatus= (row.dataset.status || '').toLowerCase();
            const rSector= (row.dataset.sector || '').toLowerCase();

            const matchQ = !q      || text.includes(q);
            const matchS = !status || rStatus === status;
            const matchC = !sector || rSector.includes(sector.toLowerCase());

            if (matchQ && matchS && matchC) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        if (rowCountEl) {
            rowCountEl.textContent = `Showing ${visible} of {{ $employers->total() }}`;
        }
    }

    searchInput?.addEventListener('input',  applyFilters);
    statusFilter?.addEventListener('change', applyFilters);
    sectorFilter?.addEventListener('change', applyFilters);
</script>
@endsection