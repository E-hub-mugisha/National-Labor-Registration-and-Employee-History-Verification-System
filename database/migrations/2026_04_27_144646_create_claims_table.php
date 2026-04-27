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
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('employment_record_id')->constrained('employment_records')->onDelete('cascade');
            $table->enum('claim_type', [
                'wrong_exit_reason', 'wrong_conduct_rating', 'wrong_dates',
                'wrong_position', 'wrong_remarks', 'other'
            ]);
            $table->text('description');                    // Employee's explanation of mismatch
            $table->string('evidence_file')->nullable();    // Optional uploaded evidence
            $table->enum('status', ['pending', 'under_review', 'resolved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();         // Govt/admin response
            $table->text('employer_response')->nullable();   // Previous employer's response
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
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
