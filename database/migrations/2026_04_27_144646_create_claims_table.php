<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();

            // ─────────────────────────────────────────────
            // Relationships
            // ─────────────────────────────────────────────
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->foreignId('employment_record_id')
                ->nullable()
                ->constrained('employment_records')
                ->nullOnDelete();

            // ─────────────────────────────────────────────
            // Claim Identification
            // ─────────────────────────────────────────────
            $table->string('reference_number')->unique(); // e.g CLM-2026-000001

            // ─────────────────────────────────────────────
            // Claim Details
            // ─────────────────────────────────────────────
            $table->enum('claim_type', [
                'wrong_exit_reason',
                'wrong_conduct_rating',
                'wrong_dates',
                'wrong_position',
                'wrong_remarks',
                'other'
            ]);

            $table->text('description'); // Employee explanation

            // ─────────────────────────────────────────────
            // Evidence
            // ─────────────────────────────────────────────
            $table->string('evidence_file')->nullable();

            // ─────────────────────────────────────────────
            // Status Lifecycle
            // ─────────────────────────────────────────────
            $table->enum('status', [
                'pending',
                'under_review',
                'resolved',
                'rejected'
            ])->default('pending');

            // Optional priority (gov use)
            $table->enum('priority', ['low', 'medium', 'high'])
                ->default('medium');

            // ─────────────────────────────────────────────
            // Responses
            // ─────────────────────────────────────────────
            $table->text('employer_response')->nullable(); // Employer side
            $table->text('admin_note')->nullable();        // Govt decision

            // ─────────────────────────────────────────────
            // Audit / Tracking
            // ─────────────────────────────────────────────
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            // Soft delete for audit safety
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
