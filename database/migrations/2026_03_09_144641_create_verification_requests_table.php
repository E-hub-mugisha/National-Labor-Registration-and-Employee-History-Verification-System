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
        Schema::create('verification_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users');
            $table->string('national_id_queried', 20);
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->enum('purpose', [
                'pre_employment_check',
                'background_verification',
                'contract_renewal',
                'security_clearance',
                'other'
            ]);
            $table->text('purpose_details')->nullable();
            $table->string('position_applied_for', 150)->nullable();
            $table->boolean('employee_found')->default(false);
            $table->json('data_returned')->nullable();
            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'unauthorized'
            ])->default('completed');
            $table->boolean('employee_consent_obtained')->default(false);
            $table->string('consent_reference')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('searched_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_requests');
    }
};
