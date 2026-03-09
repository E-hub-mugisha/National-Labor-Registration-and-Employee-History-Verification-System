<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalFeedback;
use App\Models\EmploymentRecord;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Show feedback creation form
    public function create(EmploymentRecord $record)
    {
        // Only the employer who owns the record can submit feedback
        if ($record->employer_id !== Auth::user()->employer?->id) {
            abort(403, 'Unauthorized.');
        }

        // Cannot submit feedback for active employment
        if ($record->is_current) {
            return back()->with('error', 'Cannot submit feedback for active employment. Report exit first.');
        }

        // Feedback already submitted
        if ($record->feedback) {
            return redirect()->route('employer.dashboard')
                             ->with('info', 'Feedback already submitted for this record.');
        }

        return view('feedback.create', compact('record'));
    }

    // Store feedback
    public function store(Request $request, EmploymentRecord $record)
    {
        // Only the employer who owns the record can submit feedback
        if ($record->employer_id !== Auth::user()->employer?->id) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'rating_overall'                 => 'required|integer|between:1,5',
            'rating_punctuality'             => 'required|integer|between:1,5',
            'rating_teamwork'                => 'required|integer|between:1,5',
            'rating_communication'           => 'required|integer|between:1,5',
            'rating_technical_skills'        => 'required|integer|between:1,5',
            'rating_leadership'              => 'nullable|integer|between:1,5',
            'rating_integrity'               => 'required|integer|between:1,5',
            'rating_adaptability'            => 'required|integer|between:1,5',
            'strengths'                      => 'nullable|string|max:2000',
            'areas_for_improvement'          => 'nullable|string|max:2000',
            'general_comments'               => 'nullable|string|max:3000',
            'would_rehire'                   => 'required|boolean',
            'rehire_condition'               => 'nullable|string|max:1000',
            'has_misconduct_flag'            => 'boolean',
            'misconduct_categories'          => 'required_if:has_misconduct_flag,true|array',
            'misconduct_categories.*'        => 'string|in:theft,harassment,insubordination,substance_abuse,fraud,violence,other',
            'misconduct_details'             => 'required_if:has_misconduct_flag,true|nullable|string|max:3000',
            'misconduct_legally_adjudicated' => 'boolean',
            'misconduct_case_reference'      => 'nullable|string|max:100',
            'visibility'                     => 'required|in:all_employers,verified_employers_only,hidden',
        ]);

        DB::beginTransaction();
        try {
            $feedback = ProfessionalFeedback::create([
                ...$validated,
                'employment_record_id' => $record->id,
                'employee_id'          => $record->employee_id,
                'employer_id'          => $record->employer_id,
                'submitted_by'         => Auth::id(),
                'moderation_status'    => 'pending',
                'is_published'         => false,
            ]);

            DB::commit();

            AuditLog::record(
                'created',
                'Professional feedback submitted',
                $feedback
            );

            return redirect()->route('employer.dashboard')
                             ->with('success', 'Feedback submitted. It will be published after moderation.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Feedback submission failed: ' . $e->getMessage());
            return back()->withInput()
                         ->with('error', 'Submission failed. Please try again.');
        }
    }

    // Employee responds to feedback
    public function respond(Request $request, ProfessionalFeedback $feedback)
    {
        // Only the employee can respond
        if ($feedback->employee_id !== Auth::user()->employee?->id) {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'employee_response' => 'required|string|max:2000',
        ]);

        $feedback->update([
            'employee_response'        => $request->employee_response,
            'employee_acknowledged'    => true,
            'employee_acknowledged_at' => now(),
        ]);

        AuditLog::record(
            'updated',
            'Employee responded to feedback',
            $feedback
        );

        return back()->with('success', 'Your response has been recorded.');
    }

    // Show all feedback for an employee
    public function index()
    {
        $employee = Auth::user()->employee;

        if (! $employee) {
            return redirect()->route('employee.register');
        }

        $feedback = ProfessionalFeedback::where('employee_id', $employee->id)
                                         ->with(['employer', 'employmentRecord'])
                                         ->latest()
                                         ->paginate(10);

        return view('feedback.index', compact('feedback', 'employee'));
    }
}