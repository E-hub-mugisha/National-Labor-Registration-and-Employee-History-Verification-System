{{-- resources/views/employees/search.blade.php --}}
@extends('layouts.app')

@section('title', 'Search Employee')

@push('styles')
@include('employees._layout_partial')
@endpush

@section('content')
<div class="em-wrap">

    {{-- ── Header ──────────────────────────────────── --}}
    <div class="em-header-row">
        <div>
            <h1 class="em-page-title">Employee Search</h1>
            <p class="em-page-sub">Look up any employee by their National ID</p>
        </div>
        <div style="display:flex;gap:.75rem;">
            <a href="{{ route('employees.index') }}" class="em-btn em-btn-ghost">← My Employees</a>
            <a href="{{ route('employees.create') }}" class="em-btn em-btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Register New
            </a>
        </div>
    </div>

    {{-- ── Flash ───────────────────────────────────── --}}
    @if(session('success'))
        <div class="em-alert em-alert-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Search form ─────────────────────────────── --}}
    <div class="em-card" style="max-width:560px;">
        <div class="em-card-title">Search by National ID</div>
        <form method="GET" action="{{ route('employees.search') }}" style="display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap;">
            <div class="em-field" style="flex:1;min-width:200px;">
                <label class="em-label">National ID <span class="req">*</span></label>
                <input type="text" name="national_id" class="em-input"
                       value="{{ request('national_id') }}"
                       placeholder="16-digit national ID"
                       maxlength="16"
                       style="letter-spacing:.05em;">
            </div>
            <button type="submit" class="em-btn em-btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Search
            </button>
        </form>
    </div>

    {{-- ── Search result ───────────────────────────── --}}
    @if($searched)

        @if(!$employee)
            {{-- Not found --}}
            <div class="em-card" style="max-width:560px;">
                <div style="text-align:center;padding:2rem 0;color:var(--text-dim);">
                    <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                         style="margin:0 auto 1rem;display:block;opacity:.5;color:var(--red);">
                        <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
                    </svg>
                    <p style="margin:0 0 .5rem;font-weight:600;color:var(--text);">No employee found</p>
                    <p style="margin:0;font-size:.85rem;">No record matches National ID <strong style="color:var(--text);">{{ request('national_id') }}</strong></p>
                    <a href="{{ route('employees.create') }}" class="em-btn em-btn-primary" style="margin-top:1.25rem;">
                        Register This Employee
                    </a>
                </div>
            </div>

        @else
            {{-- Found ─────────────────────────────── --}}
            @php
                $initials = strtoupper(substr($employee->first_name,0,1) . substr($employee->last_name,0,1));
                $isCurrentlyHere = $employee->current_employer_id === $employer->id;
                $hasPending = $employee->pendingTransferRequest !== null;
            @endphp

            <div class="em-card">
                {{-- Profile header --}}
                <div style="display:flex;align-items:flex-start;gap:1.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
                    @if($employee->photo)
                        <img src="{{ asset('storage/'.$employee->photo) }}" alt="" class="em-avatar">
                    @else
                        <div class="em-avatar-placeholder">{{ $initials }}</div>
                    @endif
                    <div style="flex:1;min-width:200px;">
                        <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;margin-bottom:.35rem;">
                            <h2 style="font-family:var(--font-head);font-size:1.35rem;font-weight:700;margin:0;">
                                {{ $employee->first_name }} {{ $employee->middle_name ? $employee->middle_name.' ' : '' }}{{ $employee->last_name }}
                            </h2>
                            <span class="em-badge {{ $employee->status === 'active' ? 'em-badge-active' : 'em-badge-closed' }}">
                                {{ $employee->status }}
                            </span>
                        </div>
                        <p style="margin:0 0 .5rem;color:var(--text-dim);font-size:.875rem;">
                            National ID: <span style="font-family:monospace;color:var(--text);">{{ $employee->national_id }}</span>
                        </p>
                        @if($employee->email)
                        <p style="margin:0 0 .5rem;color:var(--text-dim);font-size:.875rem;">{{ $employee->email }}</p>
                        @endif
                        @if($employee->phone)
                        <p style="margin:0;color:var(--text-dim);font-size:.875rem;">{{ $employee->phone }}</p>
                        @endif
                    </div>
                </div>

                <hr class="em-divider">

                {{-- Current employer --}}
                <div style="margin-bottom:1.25rem;">
                    <div class="em-card-title" style="margin-bottom:.75rem;">Current Employment</div>
                    @if($employee->currentEmployer)
                        <div class="em-meta-grid">
                            <div class="em-meta-item">
                                <div class="em-meta-label">Employer</div>
                                <div class="em-meta-value">{{ $employee->currentEmployer->name }}</div>
                            </div>
                            <div class="em-meta-item">
                                <div class="em-meta-label">Province / District</div>
                                <div class="em-meta-value">{{ $employee->province ?? '—' }}, {{ $employee->district ?? '—' }}</div>
                            </div>
                        </div>
                    @else
                        <p style="color:var(--text-dim);font-size:.875rem;margin:0;">Currently unemployed / not attached to any employer.</p>
                    @endif
                </div>

                {{-- Employment history --}}
                @if($employee->employmentRecords->isNotEmpty())
                <hr class="em-divider">
                <div class="em-card-title" style="margin-bottom:.75rem;">Employment History</div>
                <div class="em-table-wrap">
                    <table class="em-table">
                        <thead>
                            <tr>
                                <th>Employer</th>
                                <th>Position</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employee->employmentRecords->sortByDesc('start_date') as $rec)
                            <tr>
                                <td>{{ $rec->employer->name ?? '—' }}</td>
                                <td>{{ $rec->position }}</td>
                                <td style="font-size:.83rem;color:var(--text-dim);">
                                    {{ \Carbon\Carbon::parse($rec->start_date)->format('d M Y') }}
                                </td>
                                <td style="font-size:.83rem;color:var(--text-dim);">
                                    {{ $rec->end_date ? \Carbon\Carbon::parse($rec->end_date)->format('d M Y') : '—' }}
                                </td>
                                <td>
                                    <span class="em-badge {{ $rec->status === 'active' ? 'em-badge-active' : 'em-badge-closed' }}">
                                        {{ $rec->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <hr class="em-divider">

                {{-- Actions --}}
                <div style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;">
                    <a href="{{ route('employees.show', $employee) }}" class="em-btn em-btn-outline">
                        View Full Profile
                    </a>

                    @if($isCurrentlyHere)
                        {{-- Already under this employer --}}
                        <a href="{{ route('employees.exit', $employee) }}" class="em-btn em-btn-danger">
                            Record Exit
                        </a>
                    @elseif($employee->current_employer_id && !$hasPending)
                        {{-- Employed elsewhere — can request transfer --}}
                        <button type="button" class="em-btn em-btn-primary" onclick="document.getElementById('transfer-modal').style.display='flex'">
                            Request Transfer
                        </button>
                    @elseif($hasPending)
                        <span class="em-badge em-badge-pending" style="font-size:.8rem;padding:.4rem .8rem;">Transfer Pending</span>
                    @elseif(!$employee->current_employer_id)
                        {{-- Unemployed — direct hire --}}
                        <span style="font-size:.84rem;color:var(--text-dim);">
                            Employee is available — <a href="{{ route('employees.create') }}" style="color:var(--teal);">register them directly</a>.
                        </span>
                    @endif
                </div>
            </div>

            {{-- ── Transfer modal ─────────────────── --}}
            @if($employee->current_employer_id && !$isCurrentlyHere && !$hasPending)
            <div id="transfer-modal"
                 style="display:none;position:fixed;inset:0;background:rgba(6,15,17,.85);
                        align-items:center;justify-content:center;z-index:200;padding:1rem;">
                <div class="em-card" style="max-width:480px;width:100%;position:relative;">
                    <button onclick="document.getElementById('transfer-modal').style.display='none'"
                            style="position:absolute;top:1rem;right:1rem;background:none;border:none;
                                   color:var(--text-dim);cursor:pointer;font-size:1.2rem;">✕</button>
                    <div class="em-card-title">Request Transfer</div>
                    <p style="font-size:.875rem;color:var(--text-dim);margin:0 0 1.25rem;">
                        Transferring <strong style="color:var(--text);">{{ $employee->first_name }} {{ $employee->last_name }}</strong>
                        from <strong style="color:var(--text);">{{ $employee->currentEmployer?->name }}</strong>.
                        Their current employer will be notified.
                    </p>
                    <form method="POST" action="{{ route('employees.transfer', $employee) }}">
                        @csrf
                        <div class="em-form-grid" style="grid-template-columns:1fr;">
                            <div class="em-field">
                                <label class="em-label">Requested Position <span class="req">*</span></label>
                                <input type="text" name="requested_position" class="em-input"
                                       placeholder="e.g. Senior Accountant" required>
                            </div>
                            <div class="em-field">
                                <label class="em-label">Message (optional)</label>
                                <textarea name="message" class="em-textarea"
                                          placeholder="Add a note for the current employer…"></textarea>
                            </div>
                        </div>
                        <div style="display:flex;gap:.75rem;margin-top:1.25rem;justify-content:flex-end;">
                            <button type="button" class="em-btn em-btn-ghost"
                                    onclick="document.getElementById('transfer-modal').style.display='none'">Cancel</button>
                            <button type="submit" class="em-btn em-btn-primary">Send Transfer Request</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        @endif
    @endif

</div>
@endsection