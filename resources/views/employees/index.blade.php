{{-- resources/views/employees/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Employees')

@section('content')

{{-- ── Page header ──────────────────────────────────────────────────────── --}}
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Employees</h1>
        <p class="mt-0.5 text-sm text-slate-500">
            {{ $employees->total() }} {{ Str::plural('record', $employees->total()) }} found
        </p>
    </div>
    <a href="{{ route('employees.create') }}"
       class="inline-flex items-center gap-2 rounded-lg bg-blue-700 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        New Employee
    </a>
</div>

{{-- ── Filters ───────────────────────────────────────────────────────────── --}}
<form method="GET" action="{{ route('employees.index') }}"
      class="mb-6 flex flex-wrap gap-3 rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">

    {{-- Keyword search --}}
    <div class="relative flex-1 min-w-[200px]">
        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
        </svg>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Name, ID, email, phone…"
               class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-9 pr-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
    </div>

    {{-- Status filter --}}
    <select name="status"
            class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        <option value="">All statuses</option>
        <option value="active"      {{ request('status') === 'active'      ? 'selected' : '' }}>Active</option>
        <option value="unemployed"  {{ request('status') === 'unemployed'  ? 'selected' : '' }}>Unemployed</option>
        <option value="blacklisted" {{ request('status') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
    </select>

    {{-- Province filter --}}
    <select name="province"
            class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        <option value="">All provinces</option>
        @foreach($provinces as $p)
            <option value="{{ $p }}" {{ request('province') === $p ? 'selected' : '' }}>{{ $p }}</option>
        @endforeach
    </select>

    <button type="submit"
            class="rounded-lg bg-blue-700 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-800 transition">
        Filter
    </button>

    @if(request()->hasAny(['search','status','province']))
        <a href="{{ route('employees.index') }}"
           class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 transition">
            Clear
        </a>
    @endif
</form>

{{-- ── Table ─────────────────────────────────────────────────────────────── --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-slate-200 text-sm">
        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
            <tr>
                <th class="px-4 py-3 text-left">Employee</th>
                <th class="px-4 py-3 text-left">National ID</th>
                <th class="px-4 py-3 text-left">Contact</th>
                <th class="px-4 py-3 text-left">Location</th>
                <th class="px-4 py-3 text-left">Employer</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($employees as $employee)
                <tr class="transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            {{-- Avatar --}}
                            @if($employee->photo)
                                <img src="{{ Storage::url($employee->photo) }}"
                                     alt="{{ $employee->full_name }}"
                                     class="h-9 w-9 rounded-full object-cover ring-2 ring-white shadow-sm">
                            @else
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 font-semibold text-blue-700 text-sm shadow-sm">
                                    {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('employees.show', $employee) }}"
                                   class="font-medium text-slate-900 hover:text-blue-700 transition">
                                    {{ $employee->full_name }}
                                </a>
                                <div class="text-xs text-slate-400">{{ ucfirst($employee->gender) }} · Age {{ $employee->age }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-mono text-slate-700">{{ $employee->national_id }}</td>
                    <td class="px-4 py-3">
                        <div class="text-slate-700">{{ $employee->phone }}</div>
                        <div class="text-xs text-slate-400 truncate max-w-[160px]">{{ $employee->email }}</div>
                    </td>
                    <td class="px-4 py-3 text-slate-600">
                        {{ $employee->district }}{{ $employee->district && $employee->province ? ', ' : '' }}{{ $employee->province }}
                    </td>
                    <td class="px-4 py-3 text-slate-600">
                        {{ $employee->currentEmployer?->name ?? '—' }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="badge {{ $employee->status_badge }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('employees.show', $employee) }}"
                               title="View"
                               class="rounded p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}"
                               title="Edit"
                               class="rounded p-1.5 text-slate-400 hover:bg-slate-100 hover:text-amber-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('employees.destroy', $employee) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($employee->full_name) }}? This action can be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        title="Delete"
                                        class="rounded p-1.5 text-slate-400 hover:bg-red-50 hover:text-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-16 text-center">
                        <svg class="mx-auto mb-3 w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                        </svg>
                        <p class="font-medium text-slate-500">No employees found</p>
                        <p class="mt-1 text-sm text-slate-400">Try adjusting your filters or <a href="{{ route('employees.create') }}" class="text-blue-600 underline">add a new employee</a>.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ── Pagination ────────────────────────────────────────────────────────── --}}
@if($employees->hasPages())
    <div class="mt-5">
        {{ $employees->links() }}
    </div>
@endif

@endsection