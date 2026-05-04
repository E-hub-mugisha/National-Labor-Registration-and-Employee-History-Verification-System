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
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->string('position');                      // Job title/role
            $table->string('department')->nullable();
            $table->decimal('salary', 12, 2)->nullable();   // Optional
            $table->date('start_date');
            $table->date('end_date')->nullable();            // null = currently employed
            $table->enum('exit_reason', [
                'resigned', 'terminated', 'contract_ended', 'transferred',
                'retired', 'deceased', 'redundancy', 'mutual_agreement', 'other'
            ])->nullable();
            $table->text('exit_details')->nullable();        // Additional exit explanation
            $table->enum('conduct_rating', ['excellent', 'good', 'satisfactory', 'poor', 'very_poor'])->nullable();
            $table->text('conduct_remarks')->nullable();     // Employer's professional conduct remarks
            $table->boolean('eligible_for_rehire')->nullable();
            $table->enum('status', ['active', 'inactive', 'closed', 'disputed'])->default('active');
            $table->foreignId('recorded_by')->constrained('users'); // which employer user recorded this
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
