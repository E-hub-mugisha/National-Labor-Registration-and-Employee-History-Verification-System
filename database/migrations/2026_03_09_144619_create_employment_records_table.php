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
        Schema::create('employment_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('employer_id')->nullable()->constrained('employers')->onDelete('set null');
            $table->string('job_title', 150);
            $table->string('department', 100)->nullable();
            $table->enum('employment_type', [
                'full_time',
                'part_time',
                'contract',
                'internship',
                'volunteer',
                'attachment'
            ]);
            $table->decimal('salary_start', 12, 2)->nullable();
            $table->decimal('salary_end', 12, 2)->nullable();
            $table->string('salary_currency', 10)->default('RWF');
            $table->text('job_description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->enum('exit_reason', [
                'resignation',
                'contract_expiry',
                'mutual_agreement',
                'redundancy',
                'dismissal_misconduct',
                'dismissal_performance',
                'medical_grounds',
                'retirement',
                'death',
                'other'
            ])->nullable();
            $table->text('exit_details')->nullable();
            $table->string('exit_reference_number', 100)->nullable();
            $table->enum('record_source', [
                'employer_reported',
                'employee_self_reported',
                'government_imported'
            ])->default('employee_self_reported');
            $table->boolean('employer_verified')->default(false);
            $table->timestamp('employer_verified_at')->nullable();
            $table->boolean('employee_confirmed')->default(false);
            $table->timestamp('employee_confirmed_at')->nullable();
            $table->boolean('under_dispute')->default(false);
            $table->text('employee_dispute_note')->nullable();
            $table->enum('dispute_status', [
                'none',
                'open',
                'under_review',
                'resolved'
            ])->default('none');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_records');
    }
};
