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
        Schema::create('professional_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employment_record_id')->constrained('employment_records')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->foreignId('submitted_by')->constrained('users');
            $table->unsignedTinyInteger('rating_overall');
            $table->unsignedTinyInteger('rating_punctuality');
            $table->unsignedTinyInteger('rating_teamwork');
            $table->unsignedTinyInteger('rating_communication');
            $table->unsignedTinyInteger('rating_technical_skills');
            $table->unsignedTinyInteger('rating_leadership')->nullable();
            $table->unsignedTinyInteger('rating_integrity');
            $table->unsignedTinyInteger('rating_adaptability');
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('general_comments')->nullable();
            $table->boolean('would_rehire')->nullable();
            $table->text('rehire_condition')->nullable();
            $table->boolean('has_misconduct_flag')->default(false);
            $table->json('misconduct_categories')->nullable();
            $table->text('misconduct_details')->nullable();
            $table->boolean('misconduct_legally_adjudicated')->default(false);
            $table->string('misconduct_case_reference')->nullable();
            $table->enum('visibility', [
                'all_employers',
                'verified_employers_only',
                'hidden'
            ])->default('all_employers');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->boolean('employee_acknowledged')->default(false);
            $table->timestamp('employee_acknowledged_at')->nullable();
            $table->text('employee_response')->nullable();
            $table->enum('moderation_status', [
                'pending',
                'approved',
                'flagged',
                'removed'
            ])->default('pending');
            $table->foreignId('moderated_by')->nullable()->constrained('users');
            $table->timestamp('moderated_at')->nullable();
            $table->text('moderation_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_feedback');
    }
};
