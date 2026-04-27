<?php

namespace App\Http\Controllers;

use App\Models\EmploymentRecord;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Show all incoming transfer requests for this employer's employees.
     */
    public function index()
    {
        $employer = auth()->user()->employer;

        $incoming = TransferRequest::with(['employee', 'requestingEmployer'])
            ->where('current_employer_id', $employer->id)
            ->latest()
            ->paginate(15);

        $outgoing = TransferRequest::with(['employee', 'currentEmployer'])
            ->where('requesting_employer_id', $employer->id)
            ->latest()
            ->paginate(15);
 
        return view('transfers.index', compact('incoming', 'outgoing', 'employer'));
    }
 
    /**
     * Approve a transfer request — closes the current employment record and
     * allows the requesting employer to register the employee.
     */
    public function approve(Request $request, TransferRequest $transferRequest)
    {
        $employer = auth()->user()->employer;
        abort_if($transferRequest->current_employer_id !== $employer->id, 403);
        abort_if($transferRequest->status !== 'pending', 422, 'This request has already been processed.');
 
        $data = $request->validate([
            'response_note'       => 'nullable|string|max:500',
            'end_date'            => 'required|date',
            'conduct_rating'      => 'required|in:excellent,good,satisfactory,poor,very_poor',
            'conduct_remarks'     => 'nullable|string|max:2000',
            'eligible_for_rehire' => 'required|boolean',
            'exit_details'        => 'nullable|string|max:500',
        ]);
 
        DB::transaction(function () use ($data, $transferRequest, $employer) {
            $employee = $transferRequest->employee;
 
            // 1. Close current employment record
            $record = EmploymentRecord::where('employee_id', $employee->id)
                                      ->where('employer_id', $employer->id)
                                      ->whereNull('end_date')
                                      ->first();
 
            if ($record) {
                $record->update([
                    'end_date'            => $data['end_date'],
                    'exit_reason'         => 'transferred',
                    'exit_details'        => $data['exit_details'] ?? null,
                    'conduct_rating'      => $data['conduct_rating'],
                    'conduct_remarks'     => $data['conduct_remarks'] ?? null,
                    'eligible_for_rehire' => $data['eligible_for_rehire'],
                    'status'              => 'closed',
                ]);
            }
 
            // 2. Create new employment record at requesting employer
            EmploymentRecord::create([
                'employee_id' => $employee->id,
                'employer_id'  => $transferRequest->requesting_employer_id,
                'position'    => $transferRequest->requested_position,
                'start_date'  => now()->toDateString(),
                'status'      => 'active',
                'recorded_by' => auth()->id(),
            ]);
 
            // 3. Update employee
            $employee->update([
                'current_employer_id' => $transferRequest->requesting_employer_id,
                'status'             => 'active',
            ]);
 
            // 4. Update transfer request
            $transferRequest->update([
                'status'        => 'approved',
                'response_note' => $data['response_note'] ?? null,
                'responded_by'  => auth()->id(),
                'responded_at'  => now(),
            ]);
        });
 
        // Notify requesting employer
        $transferRequest->requestingEmployer->user->notify(
            new TransferDecided($transferRequest, 'approved')
        );
 
        return redirect()->route('transfers.index')
            ->with('success', 'Transfer approved. The employee has been moved to the new employer.');
    }
 
    /**
     * Reject a transfer request.
     */
    public function reject(Request $request, TransferRequest $transferRequest)
    {
        $employer = auth()->user()->employer;
        abort_if($transferRequest->current_employer_id !== $employer->id, 403);
        abort_if($transferRequest->status !== 'pending', 422);
 
        $data = $request->validate([
            'response_note' => 'required|string|max:500',
        ]);
 
        $transferRequest->update([
            'status'        => 'rejected',
            'response_note' => $data['response_note'],
            'responded_by'  => auth()->id(),
            'responded_at'  => now(),
        ]);
 
        $transferRequest->requestingEmployer->user->notify(
            new TransferDecided($transferRequest, 'rejected')
        );
 
        return redirect()->route('transfers.index')
            ->with('success', 'Transfer request rejected.');
    }
}
