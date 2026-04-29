@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">My Employment Records</h2>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Employer</th>
                    <th class="p-3 text-left">Position</th>
                    <th class="p-3 text-left">Department</th>
                    <th class="p-3 text-left">Start Date</th>
                    <th class="p-3 text-left">End Date</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($employee->employmentRecords as $record)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3">
                        {{ $record->employer->name ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $record->position }}
                    </td>

                    <td class="p-3">
                        {{ $record->department ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($record->start_date)->format('d M Y') }}
                    </td>

                    <td class="p-3">
                        {{ $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('d M Y') : 'Present' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="p-3">
                        @if($record->employee_verified)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                Verified
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                Pending
                            </span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td class="p-3 text-center space-x-2">

                        {{-- ACCEPT --}}
                        @if(!$record->employee_verified)
                        <form method="POST"
                              action="{{ route('employee.record.accept') }}"
                              class="inline">
                            @csrf
                            <input type="hidden" name="employment_record_id" value="{{ $record->id }}">
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                Accept
                            </button>
                        </form>
                        @endif

                        {{-- CLAIM --}}
                        <button
                            onclick="openClaimModal({{ $record->id }})"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                            Claim
                        </button>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">
                        No employment records found.
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>

{{-- ========================= --}}
{{-- CLAIM MODAL --}}
{{-- ========================= --}}
<div id="claimModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded shadow-lg w-full max-w-lg p-6">

        <h3 class="text-lg font-semibold mb-4">Submit Claim</h3>

        {{-- VALIDATION ERRORS --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-2 mb-3 rounded">
                <ul class="text-sm">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('employee.claim.store') }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="employment_record_id" id="record_id">

            {{-- CLAIM TYPE --}}
            <label class="block text-sm mb-1">Issue Type</label>
            <select name="claim_type" class="border p-2 w-full mb-3">
                <option value="">Select Issue</option>
                <option value="wrong_dates">Wrong Dates</option>
                <option value="wrong_position">Wrong Position</option>
                <option value="wrong_exit_reason">Wrong Exit Reason</option>
                <option value="wrong_conduct_rating">Wrong Conduct Rating</option>
                <option value="wrong_remarks">Wrong Remarks</option>
                <option value="other">Other</option>
            </select>

            {{-- DESCRIPTION --}}
            <label class="block text-sm mb-1">Description</label>
            <textarea name="description"
                      class="border p-2 w-full mb-3"
                      rows="4"
                      placeholder="Explain the issue in detail..."></textarea>

            {{-- FILE --}}
            <label class="block text-sm mb-1">Evidence (optional)</label>
            <input type="file" name="evidence_file" class="mb-4">

            {{-- ACTIONS --}}
            <div class="flex justify-end space-x-2">
                <button type="button"
                        onclick="closeModal()"
                        class="px-3 py-1 border rounded">
                    Cancel
                </button>

                <button class="bg-red-600 text-white px-4 py-2 rounded">
                    Submit Claim
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ========================= --}}
{{-- MODAL SCRIPT --}}
{{-- ========================= --}}
<script>
function openClaimModal(recordId) {
    document.getElementById('record_id').value = recordId;
    document.getElementById('claimModal').classList.remove('hidden');
    document.getElementById('claimModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('claimModal').classList.add('hidden');
}
</script>

@endsection