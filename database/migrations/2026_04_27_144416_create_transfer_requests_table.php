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
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('requesting_employer_id')->constrained('employers')->onDelete('cascade');
            $table->foreignId('current_employer_id')->constrained('employers')->onDelete('cascade');
            $table->string('requested_position');            // What role the new employer wants to hire for
            $table->text('message')->nullable();             // Message to previous employer
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->text('response_note')->nullable();       // Previous employer's response note
            $table->foreignId('responded_by')->nullable()->constrained('users');
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('requested_by')->constrained('users'); // who made the request
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};
