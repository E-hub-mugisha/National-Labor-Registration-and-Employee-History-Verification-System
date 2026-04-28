{{-- resources/views/employees/show.blade.php --}}
@extends('layouts.app')

@section('title', $employee->full_name)

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-5 flex items-center gap-2 text-sm text-slate-500">
    <a href="{{ route('employees.index') }}" class="hover:text-blue-600 transition">Employees</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-800 font-medium">{{ $employee->full_name }}</span>
</nav>

{{-- ── Profile header ────────────────────────────────────────────────────── --}}
<div class="mb-6 flex flex-wrap items-start gap-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

    {{-- Avatar --}}
    @if($employee->photo)
        <img src="{{ Storage::url($employee->photo) }}"
             alt="{{ $employee->full_name }}"
             class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white shadow-md">
    @else
        <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 font-bold text-3xl ring-4 ring-white shadow-md">
            {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
        </div>
    @endif

    <div class="flex-1 min-w-0">
        <div class="flex flex-wrap items-center gap-3">
            <h1 class="text-2xl font-bold text-slate-900">{{ $employee->full_name }}</h1>
            <span class="badge {{ $employee->status_badge }}">{{ ucfirst($employee->status) }}</span>
        </div>
        <p class="mt-1 font-mono text-sm text-slate-500">ID: {{ $employee->national_id }}</p>
        <div class="mt-3 flex flex-wrap gap-4 text-sm text-slate-600">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ $employee->phone }}
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                {{ $employee->email }}
            </span>
            @if($employee->province)
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $employee->district }}{{ $employee->district && $employee->province ? ', ' : '' }}{{ $employee->province }}
            </span>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-2">
        <a href="{{ route('employees.edit', $employee) }}"
           class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
        <form method="POST" action="{{ route('employees.destroy', $employee) }}"
              onsubmit="return confirm('Soft-delete {{ addslashes($employee->full_name) }}?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 shadow-sm hover:bg-red-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete
            </button>
        </form>
    </div>
</div>

{{-- ── Details grid ──────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- Left: detail cards --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Personal details --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-800">Personal Details</h2>
            </div>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-4 p-6 sm:grid-cols-3 text-sm">
                <x-detail-item label="Date of Birth" :value="$employee->date_of_birth->format('d M Y')" />
                <x-detail-item label="Age" :value="$employee->age . ' years'" />
                <x-detail-item label="Gender" :value="ucfirst($employee->gender)" />
                <x-detail-item label="Qualification" :value="$employee->highest_qualification ?? '—'" />
                @if($employee->skills)
                <div class="col-span-2 sm:col-span-3">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Skills</dt>
                    <dd class="mt-1 text-slate-700 whitespace-pre-line">{{ $employee->skills }}</dd>
                </div>
                @endif
            </dl>
        </div>

        {{-- Employment records --}}
        @if($employee->employmentRecords->isNotEmpty())
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-800">Employment History</h2>
            </div>
            <ul class="divide-y divide-slate-100">
                @foreach($employee->employmentRecords as $record)
                <li class="flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="font-medium text-slate-800">{{ $record->employer->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-slate-500">
                            {{ $record->start_date?->format('M Y') }}
                            – {{ $record->end_date?->format('M Y') ?? 'Present' }}
                        </p>
                    </div>
                    @if(is_null($record->end_date))
                        <span class="badge bg-emerald-100 text-emerald-800">Current</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Claims --}}
        @if($employee->claims->isNotEmpty())
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-800">Claims ({{ $employee->claims->count() }})</h2>
            </div>
            <ul class="divide-y divide-slate-100 text-sm">
                @foreach($employee->claims as $claim)
                <li class="flex items-center justify-between px-6 py-3">
                    <span class="text-slate-700">{{ $claim->reference ?? 'Claim #' . $claim->id }}</span>
                    <span class="badge
                        {{ match($claim->status ?? '') {
                            'approved' => 'bg-emerald-100 text-emerald-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            default    => 'bg-amber-100 text-amber-800'
                        } }}">
                        {{ ucfirst($claim->status ?? 'pending') }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>

    {{-- Right: sidebar --}}
    <div class="space-y-6">

        {{-- Current employer card --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-800">Current Employer</h2>
            </div>
            <div class="p-6">
                @if($employee->currentEmployer)
                    <p class="font-medium text-slate-800">{{ $employee->currentEmployer->name }}</p>
                    @isset($employee->currentEmployer->phone)
                        <p class="mt-1 text-sm text-slate-500">{{ $employee->currentEmployer->phone }}</p>
                    @endisset
                @else
                    <p class="text-sm text-slate-400 italic">No current employer on record.</p>
                @endif
            </div>
        </div>

        {{-- Transfer requests --}}
        @if($employee->transferRequests->isNotEmpty())
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-800">Transfer Requests</h2>
            </div>
            <ul class="divide-y divide-slate-100 text-sm">
                @foreach($employee->transferRequests as $tr)
                <li class="flex items-center justify-between px-6 py-3">
                    <span class="text-slate-600 text-xs">{{ $tr->created_at->format('d M Y') }}</span>
                    <span class="badge
                        {{ match($tr->status) {
                            'approved' => 'bg-emerald-100 text-emerald-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            default    => 'bg-amber-100 text-amber-800'
                        } }}">
                        {{ ucfirst($tr->status) }}
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Meta --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-800">Record Info</h2>
            </div>
            <dl class="space-y-3 p-6 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Created</dt>
                    <dd class="text-slate-700">{{ $employee->created_at->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Last updated</dt>
                    <dd class="text-slate-700">{{ $employee->updated_at->diffForHumans() }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>


@endsection