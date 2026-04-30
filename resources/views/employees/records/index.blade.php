@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    :root {
        --bs-body-font-family: 'Plus Jakarta Sans', sans-serif;
        --brand:        #1a56db;
        --brand-dark:   #1240a0;
        --brand-soft:   #eff4ff;
        --success-soft: #ecfdf5;
        --warn-soft:    #fffbeb;
        --danger-soft:  #fff1f2;
        --surface:      #f8f9fc;
        --card-border:  #e8ecf4;
        --text-muted:   #8492a6;
        --text-body:    #1e2740;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--surface);
        color: var(--text-body);
        -webkit-font-smoothing: antialiased;
    }

    /* ── Page wrapper ─────────────────────────────────────── */
    .page-wrap { max-width: 1100px; margin: 0 auto; padding: 36px 20px 72px; }

    /* ── Page header ─────────────────────────────────────── */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-body);
        letter-spacing: -.4px;
        margin: 0;
    }
    .page-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin: 2px 0 0;
        font-weight: 400;
    }

    /* ── Card ─────────────────────────────────────────────── */
    .rec-card {
        background: #fff;
        border: 1px solid var(--card-border);
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(30,39,64,.05);
        overflow: hidden;
    }

    /* ── Table ────────────────────────────────────────────── */
    .rec-table { margin: 0; font-size: 14px; }
    .rec-table thead th {
        background: var(--surface);
        border-bottom: 1px solid var(--card-border);
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        padding: 13px 18px;
        white-space: nowrap;
    }
    .rec-table tbody tr {
        border-bottom: 1px solid #f1f4fa;
        transition: background .12s;
    }
    .rec-table tbody tr:last-child { border-bottom: none; }
    .rec-table tbody tr:hover { background: #fafbff; }
    .rec-table td { padding: 15px 18px; vertical-align: middle; }

    /* employer cell */
    .employer-cell { display: flex; align-items: center; gap: 11px; }
    .employer-avatar {
        width: 36px; height: 36px; border-radius: 9px;
        background: var(--brand-soft);
        color: var(--brand);
        font-weight: 800; font-size: 13px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        border: 1px solid #d4e2fd;
    }
    .employer-name { font-weight: 600; color: var(--text-body); font-size: 14px; }

    /* position cell */
    .position-name { font-weight: 500; }
    .dept-tag {
        display: inline-block;
        font-size: 11px; font-weight: 600;
        color: #6b7a99;
        background: #f1f4fa;
        border-radius: 5px;
        padding: 1px 7px;
        margin-top: 3px;
    }

    /* date cell */
    .date-val { font-size: 13.5px; font-weight: 500; }
    .date-label { font-size: 11px; color: var(--text-muted); }

    /* ── Badges ───────────────────────────────────────────── */
    .badge-verified {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--success-soft);
        color: #0d7a4e;
        border: 1px solid #a7f3d0;
        border-radius: 999px;
        font-size: 11.5px; font-weight: 600;
        padding: 3px 10px;
    }
    .badge-pending {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--warn-soft);
        color: #92600a;
        border: 1px solid #fcd34d;
        border-radius: 999px;
        font-size: 11.5px; font-weight: 600;
        padding: 3px 10px;
    }
    .badge-present {
        display: inline-flex; align-items: center; gap: 4px;
        background: #eff4ff;
        color: var(--brand);
        border-radius: 5px;
        font-size: 11px; font-weight: 700;
        padding: 2px 7px;
    }

    /* ── Action buttons ───────────────────────────────────── */
    .btn-accept {
        display: inline-flex; align-items: center; gap: 5px;
        background: #ecfdf5;
        color: #0d7a4e;
        border: 1px solid #a7f3d0;
        border-radius: 7px;
        font-size: 12px; font-weight: 600;
        padding: 5px 11px;
        cursor: pointer;
        transition: background .15s, border-color .15s;
        text-decoration: none;
        font-family: inherit;
    }
    .btn-accept:hover { background: #d1fae5; border-color: #6ee7b7; }

    .btn-claim {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--danger-soft);
        color: #be123c;
        border: 1px solid #fecdd3;
        border-radius: 7px;
        font-size: 12px; font-weight: 600;
        padding: 5px 11px;
        cursor: pointer;
        transition: background .15s, border-color .15s;
        font-family: inherit;
    }
    .btn-claim:hover { background: #ffe4e6; border-color: #fda4af; }

    /* ── Empty state ──────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 56px 24px;
        color: var(--text-muted);
    }
    .empty-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        background: var(--surface);
        border: 1px solid var(--card-border);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
        font-size: 22px;
        color: #b0bcd4;
    }
    .empty-title { font-weight: 700; font-size: 15px; color: #4a5568; margin-bottom: 4px; }
    .empty-sub   { font-size: 13px; }

    /* ── Flash alert ─────────────────────────────────────── */
    .flash-success {
        display: flex; align-items: center; gap: 10px;
        background: var(--success-soft);
        border: 1px solid #a7f3d0;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 14px; font-weight: 500;
        color: #0d7a4e;
    }

    /* ── Modal ────────────────────────────────────────────── */
    .modal-content {
        border: none;
        border-radius: 18px;
        box-shadow: 0 24px 80px rgba(0,0,0,.18);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .modal-header {
        border-bottom: 1px solid #f1f4fa;
        padding: 22px 26px 18px;
        background: #fff;
        border-radius: 18px 18px 0 0;
    }
    .modal-title-wrap { display: flex; align-items: center; gap: 12px; }
    .modal-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--danger-soft);
        border: 1px solid #fecdd3;
        display: flex; align-items: center; justify-content: center;
        color: #be123c; font-size: 18px;
        flex-shrink: 0;
    }
    .modal-title {
        font-size: 16px; font-weight: 800;
        color: var(--text-body);
        margin: 0;
        letter-spacing: -.2px;
    }
    .modal-subtitle { font-size: 12px; color: var(--text-muted); margin: 2px 0 0; }
    .modal-body { padding: 22px 26px; background: #fafbff; }
    .modal-footer {
        background: #fff;
        border-top: 1px solid #f1f4fa;
        padding: 16px 26px;
        border-radius: 0 0 18px 18px;
        display: flex; justify-content: flex-end; gap: 10px;
    }

    /* form fields */
    .form-label {
        font-size: 12px; font-weight: 700;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 6px;
    }
    .form-control, .form-select {
        border: 1px solid #dde3ef;
        border-radius: 9px;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 9px 13px;
        color: var(--text-body);
        background: #fff;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(26,86,219,.1);
    }
    textarea.form-control { resize: vertical; min-height: 100px; }

    .file-upload-wrap {
        border: 2px dashed #dde3ef;
        border-radius: 10px;
        padding: 18px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        background: #fff;
    }
    .file-upload-wrap:hover { border-color: var(--brand); background: var(--brand-soft); }
    .file-upload-wrap input[type=file] { display: none; }
    .file-upload-label { font-size: 13px; color: var(--text-muted); cursor: pointer; display: block; }
    .file-upload-icon  { font-size: 22px; color: #b0bcd4; display: block; margin-bottom: 5px; }

    /* modal buttons */
    .btn-modal-cancel {
        background: #fff;
        border: 1px solid #dde3ef;
        border-radius: 9px;
        color: #6b7a99;
        font-size: 14px; font-weight: 600;
        padding: 9px 20px;
        font-family: inherit;
        transition: background .15s;
        cursor: pointer;
    }
    .btn-modal-cancel:hover { background: #f5f7fb; }
    .btn-modal-submit {
        background: linear-gradient(135deg, #e11d48, #be123c);
        border: none;
        border-radius: 9px;
        color: #fff;
        font-size: 14px; font-weight: 700;
        padding: 9px 22px;
        font-family: inherit;
        box-shadow: 0 4px 14px rgba(190,18,60,.3);
        cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px;
        transition: opacity .15s, transform .15s;
    }
    .btn-modal-submit:hover { opacity: .9; transform: translateY(-1px); }

    /* error list */
    .error-box {
        background: var(--danger-soft);
        border: 1px solid #fecdd3;
        border-radius: 9px;
        padding: 12px 14px;
        margin-bottom: 16px;
        font-size: 13px; color: #be123c;
    }
    .error-box li { list-style: none; margin: 2px 0; }
    .error-box li::before { content: '· '; font-weight: 700; }

    /* animations */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .page-wrap { animation: fadeInDown .35s ease both; }
</style>

<div class="page-wrap">

    {{-- ── Page Header ──────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="bi bi-briefcase me-2" style="color:var(--brand);font-size:20px;vertical-align:-2px"></i>
                Employment Records
            </h1>
            <p class="page-subtitle">Review and manage your verified work history</p>
        </div>
        <div style="font-size:13px;color:var(--text-muted);font-weight:500;">
            <i class="bi bi-shield-check me-1" style="color:#0d7a4e"></i>
            {{ $employee->employmentRecords->where('employee_verified', true)->count() }}
            of {{ $employee->employmentRecords->count() }} verified
        </div>
    </div>

    {{-- ── Flash ─────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="flash-success">
            <i class="bi bi-check-circle-fill fs-5"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Table Card ────────────────────────────────────────── --}}
    <div class="rec-card">
        <table class="table rec-table">
            <thead>
                <tr>
                    <th>Employer</th>
                    <th>Position / Dept</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($employee->employmentRecords as $record)
                <tr>
                    {{-- Employer --}}
                    <td>
                        <div class="employer-cell">
                            <div class="employer-avatar">
                                {{ strtoupper(substr($record->employer->name ?? '?', 0, 2)) }}
                            </div>
                            <span class="employer-name">{{ $record->employer->name ?? '—' }}</span>
                        </div>
                    </td>

                    {{-- Position + Dept --}}
                    <td>
                        <div class="position-name">{{ $record->position }}</div>
                        @if($record->department)
                            <span class="dept-tag">{{ $record->department }}</span>
                        @endif
                    </td>

                    {{-- Start --}}
                    <td>
                        <div class="date-val">{{ \Carbon\Carbon::parse($record->start_date)->format('d M Y') }}</div>
                    </td>

                    {{-- End --}}
                    <td>
                        @if($record->end_date)
                            <div class="date-val">{{ \Carbon\Carbon::parse($record->end_date)->format('d M Y') }}</div>
                        @else
                            <span class="badge-present"><i class="bi bi-dot" style="font-size:16px;margin:-2px"></i>Present</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($record->employee_verified)
                            <span class="badge-verified">
                                <i class="bi bi-shield-fill-check" style="font-size:12px"></i>
                                Verified
                            </span>
                        @else
                            <span class="badge-pending">
                                <i class="bi bi-clock" style="font-size:12px"></i>
                                Pending
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            @if(!$record->employee_verified)
                                <form method="POST" action="{{ route('employee.record.accept') }}" class="m-0">
                                    @csrf
                                    <input type="hidden" name="employment_record_id" value="{{ $record->id }}">
                                    <button type="submit" class="btn-accept">
                                        <i class="bi bi-check-lg"></i> Accept
                                    </button>
                                </form>
                            @endif
                            <button type="button"
                                    class="btn-claim"
                                    onclick="openClaimModal({{ $record->id }}, '{{ addslashes($record->employer->name ?? 'Unknown') }}', '{{ addslashes($record->position) }}')">
                                <i class="bi bi-flag"></i> Claim
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-briefcase"></i></div>
                            <div class="empty-title">No employment records</div>
                            <div class="empty-sub">Your employment history will appear here once records are added.</div>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ══════════════════════════════════════════════ --}}
{{-- CLAIM MODAL                                     --}}
{{-- ══════════════════════════════════════════════ --}}
<div class="modal fade" id="claimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <div class="modal-icon"><i class="bi bi-flag-fill"></i></div>
                    <div>
                        <div class="modal-title">Submit a Claim</div>
                        <div class="modal-subtitle" id="modalSubtitle">Report an issue with your employment record</div>
                    </div>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">

                {{-- Validation errors --}}
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
                    <input type="hidden" name="employment_record_id" id="record_id">

                    {{-- Issue type --}}
                    <div class="mb-3">
                        <label class="form-label">Issue Type</label>
                        <select name="claim_type" class="form-select" required>
                            <option value="" disabled selected>Select an issue type…</option>
                            <option value="wrong_dates">Wrong Dates</option>
                            <option value="wrong_position">Wrong Position</option>
                            <option value="wrong_exit_reason">Wrong Exit Reason</option>
                            <option value="wrong_conduct_rating">Wrong Conduct Rating</option>
                            <option value="wrong_remarks">Wrong Remarks</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  placeholder="Describe the issue in detail…"
                                  required></textarea>
                    </div>

                    {{-- Evidence --}}
                    <div class="mb-1">
                        <label class="form-label">Evidence <span style="color:#b0bcd4;font-weight:400;text-transform:none;letter-spacing:0">(optional)</span></label>
                        <div class="file-upload-wrap" onclick="document.getElementById('evidence_file').click()">
                            <i class="bi bi-cloud-arrow-up file-upload-icon"></i>
                            <label class="file-upload-label" id="fileLabel">
                                Click to upload a file &nbsp;·&nbsp; PDF, JPG, PNG up to 10 MB
                            </label>
                            <input type="file" id="evidence_file" name="evidence_file"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   onchange="updateFileLabel(this)">
                        </div>
                    </div>

                </form>
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" form="claimForm" class="btn-modal-submit">
                    <i class="bi bi-send"></i> Submit Claim
                </button>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const claimModal = new bootstrap.Modal(document.getElementById('claimModal'));

    function openClaimModal(recordId, employerName, position) {
        document.getElementById('record_id').value = recordId;
        document.getElementById('modalSubtitle').textContent =
            employerName + ' · ' + position;
        claimModal.show();
    }

    function updateFileLabel(input) {
        const label = document.getElementById('fileLabel');
        if (input.files && input.files[0]) {
            label.textContent = '📎 ' + input.files[0].name;
        } else {
            label.textContent = 'Click to upload a file · PDF, JPG, PNG up to 10 MB';
        }
    }

    // Re-open modal on validation error
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => claimModal.show());
    @endif
</script>
@endsection