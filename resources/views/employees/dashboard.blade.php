@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        Welcome, {{ $employee->full_name }}
    </h2>

    {{-- PROFILE --}}
    <div class="bg-white p-4 rounded shadow mb-6">
        <h3 class="font-semibold mb-2">Profile</h3>
        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Phone:</strong> {{ $employee->phone }}</p>
        <p><strong>Current Employer:</strong> {{ $employee->currentEmployer->name ?? 'Unemployed' }}</p>
    </div>

    {{-- EMPLOYMENT HISTORY --}}
    <div class="bg-white p-4 rounded shadow mb-6">
        <h3 class="font-semibold mb-4">Employment History</h3>

        @forelse($employee->employmentRecords as $record)
            <div class="border-l-4 border-blue-500 pl-4 mb-4">
                <p class="font-semibold">
                    {{ $record->employer->name ?? 'N/A' }}
                </p>
                <p>{{ $record->position }}</p>
                <p class="text-sm text-gray-500">
                    {{ $record->start_date }} →
                    {{ $record->end_date ?? 'Present' }}
                </p>
            </div>
        @empty
            <p>No employment history available.</p>
        @endforelse
    </div>

    {{-- CLAIM FORM --}}
    <div class="bg-white p-4 rounded shadow mb-6">
        <h3 class="font-semibold mb-4">Submit a Claim / Dispute</h3>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-3">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('employee.claim.store') }}">
            @csrf

            <select name="type" class="border p-2 w-full mb-3">
                <option value="">Select Issue Type</option>
                <option value="wrong_employer">Wrong Employer</option>
                <option value="wrong_dates">Incorrect Dates</option>
                <option value="position_error">Position Error</option>
                <option value="other">Other</option>
            </select>

            <textarea name="description"
                placeholder="Describe the issue..."
                class="border p-2 w-full mb-3"></textarea>

            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Submit Claim
            </button>
        </form>
    </div>

    {{-- CLAIM HISTORY --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-4">My Claims</h3>

        @forelse($employee->claims as $claim)
            <div class="border p-3 mb-2 rounded">
                <p><strong>{{ ucfirst($claim->type) }}</strong></p>
                <p>{{ $claim->description }}</p>
                <span class="text-sm px-2 py-1 rounded {{ $claim->status == 'pending' ? 'bg-yellow-100' : 'bg-green-100' }}">
                    {{ ucfirst($claim->status) }}
                </span>
            </div>
        @empty
            <p>No claims submitted.</p>
        @endforelse
    </div>

</div>
@endsection