{{-- resources/views/employees/search.blade.php --}}
@extends('layouts.app')

@section('title', 'Search by National ID')

@section('content')

<div class="mx-auto max-w-2xl">

    {{-- ── Page heading ──────────────────────────────────────────────────── --}}
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-700 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0M9 14h.01M15 14h.01M9 10h6"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">Employee Lookup</h1>
        <p class="mt-1 text-slate-500">Enter a National ID to retrieve the employee record instantly.</p>
    </div>

    {{-- ── Search form ───────────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('employees.search') }}"
          class="flex gap-3">
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input type="text"
                   name="national_id"
                   id="national_id"
                   value="{{ request('national_id') }}"
                   autofocus
                   autocomplete="off"
                   placeholder="Enter National ID…"
                   class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 font-mono text-base shadow-sm
                          focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition">
        </div>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-6 py-3 font-semibold text-white shadow hover:bg-blue-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            Search
        </button>
    </form>

    {{-- ── Results ────────────────────────────────────────────────────────── --}}
    <div class="mt-8">

        {{-- Not found state --}}
        @if($searched && ! $employee)
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-6 py-8 text-center">
                <svg class="mx-auto mb-3 w-12 h-12 text-amber-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                <p class="font-semibold text-amber-800">No record found</p>
                <p class="mt-1 text-sm text-amber-700">
                    No employee matched National ID
                    <strong class="font-mono">{{ request('national_id') }}</strong>.
                </p>
                <a href="{{ route('employees.create') }}"
                   class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Employee
                </a>
            </div>
        @endif

        {{-- Found state --}}
        @if($employee)
            <div class="rounded-xl border border-slate-200 bg-white shadow-md overflow-hidden">

                {{-- Coloured top bar by status --}}
                <div class="h-1.5 {{ $employee->status === 'active' ? 'bg-emerald-500' : ($employee->status === 'blacklisted' ? 'bg-red-500' : 'bg-slate-300') }}"></div>

                <div class="flex flex-wrap items-start gap-5 p-6">
                    {{-- Avatar --}}
                    @if($employee->photo)
                        <img src="{{ Storage::url($employee->photo) }}"
                             alt="{{ $employee->full_name }}"
                             class="h-20 w-20 rounded-2xl object-cover ring-4 ring-white shadow-md">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 font-bold text-2xl ring-4 ring-white shadow-md">
                            {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-xl font-bold text-slate-900">{{ $employee->full_name }}</h2>
                            <span class="badge {{ $employee->status_badge }}">{{ ucfirst($employee->status) }}</span>
                        </div>
                        <p class="mt-0.5 font-mono text-sm text-slate-500">{{ $employee->national_id }}</p>

                        {{-- Quick detail grid --}}
                        <dl class="mt-4 grid grid-cols-2 gap-x-8 gap-y-3 text-sm sm:grid-cols-3">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Date of Birth</dt>
                                <dd class="mt-0.5 text-slate-700">{{ $employee->date_of_birth->format('d M Y') }} ({{ $employee->age }} yrs)</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Gender</dt>
                                <dd class="mt-0.5 text-slate-700">{{ ucfirst($employee->gender) }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Phone</dt>
                                <dd class="mt-0.5 text-slate-700">{{ $employee->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Email</dt>
                                <dd class="mt-0.5 text-slate-700 truncate">{{ $employee->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Location</dt>
                                <dd class="mt-0.5 text-slate-700">
                                    {{ $employee->district }}{{ $employee->district && $employee->province ? ', ' : '' }}{{ $employee->province ?? '—' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Current Employer</dt>
                                <dd class="mt-0.5 text-slate-700">{{ $employee->currentEmployer?->name ?? '—' }}</dd>
                            </div>
                        </dl>

                        @if($employee->highest_qualification)
                        <p class="mt-3 text-sm text-slate-600">
                            <span class="font-medium">Qualification:</span> {{ $employee->highest_qualification }}
                        </p>
                        @endif

                        @if($employee->skills)
                        <p class="mt-1 text-sm text-slate-600">
                            <span class="font-medium">Skills:</span> {{ $employee->skills }}
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Employment history snippet --}}
                @if($employee->employmentRecords->isNotEmpty())
                <div class="border-t border-slate-100 px-6 py-4">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Employment History</p>
                    <ul class="space-y-1.5">
                        @foreach($employee->employmentRecords->take(3) as $record)
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-slate-700">{{ $record->employer->name ?? 'Unknown' }}</span>
                            <span class="text-slate-400">
                                {{ $record->start_date?->format('M Y') }} –
                                {{ $record->end_date?->format('M Y') ?? 'Present' }}
                            </span>
                        </li>
                        @endforeach
                        @if($employee->employmentRecords->count() > 3)
                            <li class="text-xs text-slate-400">+ {{ $employee->employmentRecords->count() - 3 }} more records</li>
                        @endif
                    </ul>
                </div>
                @endif

                {{-- Claims snippet --}}
                @if($employee->claims->isNotEmpty())
                <div class="border-t border-slate-100 px-6 py-4">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Claims ({{ $employee->claims->count() }})</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($employee->claims->take(5) as $claim)
                        <span class="badge
                            {{ match($claim->status ?? '') {
                                'approved' => 'bg-emerald-100 text-emerald-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                default    => 'bg-amber-100 text-amber-800'
                            } }}">
                            {{ $claim->reference ?? '#' . $claim->id }} · {{ ucfirst($claim->status ?? 'pending') }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4 bg-slate-50">
                    <a href="{{ route('employees.show', $employee) }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-blue-800 transition">
                        View Full Profile
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('employees.edit', $employee) }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        Edit
                    </a>
                </div>
            </div>
        @endif

        {{-- Empty / initial state --}}
        @if(! $searched)
            <div class="rounded-xl border border-dashed border-slate-200 bg-white px-6 py-16 text-center">
                <svg class="mx-auto mb-3 w-12 h-12 text-slate-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0M9 14h.01M15 14h.01M9 10h6"/>
                </svg>
                <p class="font-medium text-slate-400">Enter a National ID above to search</p>
            </div>
        @endif
    </div>

</div>

@endsection