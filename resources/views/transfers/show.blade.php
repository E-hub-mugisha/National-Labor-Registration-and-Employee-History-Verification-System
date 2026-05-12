@extends('layouts.app')

@section('title', 'Transfer Request - ' . $transferRequest->employee->full_name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100">
    <!-- Header -->
    <div class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('transfers.index') }}" class="mb-3 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Transfers
                    </a>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        {{ $transferRequest->employee->full_name }}
                    </h1>
                </div>
                <div>
                    <span class="inline-block rounded-full {{ $transferRequest->status_badge }} px-4 py-2 text-sm font-semibold uppercase">
                        {{ $transferRequest->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Employee Information -->
                <section class="rounded-lg border border-slate-200 bg-white p-6">
                    <h2 class="mb-6 flex items-center text-xl font-semibold text-slate-900">
                        <svg class="mr-3 h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        Employee Information
                    </h2>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Full Name</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transferRequest->employee->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Employee ID</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transferRequest->employee->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Email</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transferRequest->employee->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Phone</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transferRequest->employee->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </section>

                <!-- Transfer Details -->
                <section class="rounded-lg border border-slate-200 bg-white p-6">
                    <h2 class="mb-6 flex items-center text-xl font-semibold text-slate-900">
                        <svg class="mr-3 h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2.101a7.002 7.002 0 0111.601-2.566 1 1 0 11-1.414 1.414A5.002 5.002 0 005.999 10H8a1 1 0 110 2H2a1 1 0 01-1-1z"></path>
                            <path d="M18 9a1 1 0 01-1 1h-2.101a7.002 7.002 0 01-11.601 2.566 1 1 0 111.414 1.414A5.002 5.002 0 0014.001 10H12a1 1 0 110-2h6a1 1 0 011 1z"></path>
                        </svg>
                        Transfer Details
                    </h2>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Current Employer</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transferRequest->currentEmployer->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Current Position</p>
                            <p class="mt-2 text-lg font-semibold text-slate-900">
                                {{ $transferRequest->employee->employmentRecord?->position ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Requesting Employer</p>
                            <p class="mt-2 text-lg font-semibold text-emerald-600">{{ $transferRequest->requestingEmployer->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Requested Position</p>
                            <p class="mt-2 text-lg font-semibold text-emerald-600">{{ $transferRequest->requested_position }}</p>
                        </div>
                    </div>

                    @if($transferRequest->message)
                        <div class="mt-6 rounded-lg border-l-4 border-blue-400 bg-blue-50 p-4">
                            <p class="text-xs font-semibold uppercase text-blue-600">Request Message</p>
                            <p class="mt-2 text-sm text-blue-900">{{ $transferRequest->message }}</p>
                        </div>
                    @endif
                </section>

                <!-- Current Employment Record -->
                @if($transferRequest->employee->employmentRecord)
                    <section class="rounded-lg border border-slate-200 bg-white p-6">
                        <h2 class="mb-6 flex items-center text-xl font-semibold text-slate-900">
                            <svg class="mr-3 h-6 w-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zm-6 8a2 2 0 11-4 0 2 2 0 014 0zM9 17a6 6 0 1012 0 6 6 0 00-12 0z"></path>
                            </svg>
                            Current Employment Record
                        </h2>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Start Date</p>
                                <p class="mt-2 text-lg font-semibold text-slate-900">
                                    {{ $transferRequest->employee->employmentRecord->start_date->format('M d, Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Duration</p>
                                <p class="mt-2 text-lg font-semibold text-slate-900">
                                    {{ $transferRequest->employee->employmentRecord->start_date->diffInMonths(now()) }} months
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Department</p>
                                <p class="mt-2 text-lg font-semibold text-slate-900">
                                    {{ $transferRequest->employee->employmentRecord->department ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Status</p>
                                <p class="mt-2">
                                    <span class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800">
                                        {{ ucfirst($transferRequest->employee->employmentRecord->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Approval Form (if pending) -->
                @if($transferRequest->status === 'pending')
                    <form method="POST" action="{{ route('transfers.approve', $transferRequest) }}" class="rounded-lg border border-slate-200 bg-white p-6">
                        @csrf

                        <h2 class="mb-6 flex items-center text-xl font-semibold text-slate-900">
                            <svg class="mr-3 h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Approve Transfer
                        </h2>

                        <div class="space-y-6">
                            <!-- End Date -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900">
                                    End Date <span class="text-red-600">*</span>
                                </label>
                                <input type="date" name="end_date" required
                                    class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    value="{{ old('end_date', today()->toDateString()) }}">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Conduct Rating -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900">
                                    Conduct Rating <span class="text-red-600">*</span>
                                </label>
                                <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-5">
                                    @foreach(['excellent' => 'Excellent', 'good' => 'Good', 'satisfactory' => 'Satisfactory', 'poor' => 'Poor', 'very_poor' => 'Very Poor'] as $value => $label)
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="conduct_rating" value="{{ $value }}" required
                                                class="h-4 w-4 border-slate-300 text-blue-600 focus:ring-blue-500"
                                                {{ old('conduct_rating') === $value ? 'checked' : '' }}>
                                            <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('conduct_rating')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Conduct Remarks -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900">Conduct Remarks</label>
                                <textarea name="conduct_remarks" rows="3" placeholder="Any additional remarks about the employee's conduct..."
                                    class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('conduct_remarks') }}</textarea>
                                @error('conduct_remarks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Eligible for Rehire -->
                            <div>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="eligible_for_rehire" value="1"
                                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                        {{ old('eligible_for_rehire') ? 'checked' : '' }}>
                                    <span class="text-sm font-medium text-slate-700">Eligible for Rehire</span>
                                </label>
                                @error('eligible_for_rehire')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Exit Details -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900">Exit Details</label>
                                <textarea name="exit_details" rows="3" placeholder="Details about the employee's exit..."
                                    class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('exit_details') }}</textarea>
                                @error('exit_details')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Response Note -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900">Response Note</label>
                                <textarea name="response_note" rows="3" placeholder="Optional note to send to the requesting employer..."
                                    class="mt-2 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ old('response_note') }}</textarea>
                                @error('response_note')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-between border-t border-slate-200 pt-6">
                            <a href="{{ route('transfers.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-700">
                                Cancel
                            </a>
                            <button type="submit" class="rounded-lg bg-emerald-600 px-6 py-2.5 font-semibold text-white hover:bg-emerald-700 transition-colors">
                                Approve Transfer
                            </button>
                        </div>
                    </form>
                @else
                    <!-- Response Summary (if already processed) -->
                    <section class="rounded-lg border border-slate-200 bg-white p-6">
                        <h2 class="mb-6 flex items-center text-xl font-semibold text-slate-900">
                            <svg class="mr-3 h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                            </svg>
                            Response
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Status</p>
                                <p class="mt-2">
                                    <span class="inline-block rounded-full {{ $transferRequest->status_badge }} px-3 py-1 text-sm font-semibold uppercase">
                                        {{ $transferRequest->status }}
                                    </span>
                                </p>
                            </div>

                            @if($transferRequest->responded_at)
                                <div>
                                    <p class="text-xs font-semibold uppercase text-slate-500">Responded At</p>
                                    <p class="mt-2 text-sm font-semibold text-slate-900">
                                        {{ $transferRequest->responded_at->format('M d, Y \a\t g:i A') }}
                                    </p>
                                </div>
                            @endif

                            @if($transferRequest->response_note)
                                <div>
                                    <p class="text-xs font-semibold uppercase text-slate-500">Note</p>
                                    <p class="mt-2 text-sm text-slate-700">{{ $transferRequest->response_note }}</p>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Timeline -->
                <div class="rounded-lg border border-slate-200 bg-white p-6">
                    <h3 class="mb-6 text-lg font-semibold text-slate-900">Timeline</h3>

                    <div class="space-y-6">
                        <!-- Requested -->
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @if($transferRequest->responded_at)
                                    <div class="h-12 w-0.5 bg-slate-300 mt-2"></div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">Requested</p>
                                <p class="text-sm text-slate-600">{{ $transferRequest->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Responded -->
                        @if($transferRequest->responded_at)
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="h-8 w-8 rounded-full {{ $transferRequest->status === 'approved' ? 'bg-emerald-100' : 'bg-red-100' }} flex items-center justify-center">
                                        <svg class="h-4 w-4 {{ $transferRequest->status === 'approved' ? 'text-emerald-600' : 'text-red-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            @if($transferRequest->status === 'approved')
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            @else
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            @endif
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ ucfirst($transferRequest->status) }}</p>
                                    <p class="text-sm text-slate-600">{{ $transferRequest->responded_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="mt-6 rounded-lg border border-slate-200 bg-white p-6">
                    <h3 class="mb-4 text-lg font-semibold text-slate-900">Quick Info</h3>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Requested By</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $transferRequest->requestedBy?->name ?? 'System' }}
                            </p>
                        </div>

                        @if($transferRequest->responded_at)
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Responded By</p>
                                <p class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $transferRequest->respondedBy?->name ?? 'Unknown' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
