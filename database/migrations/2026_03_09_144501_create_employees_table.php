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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('national_id', 20)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('nationality', 60)->default('Rwandan');
            $table->string('province', 60)->nullable();
            $table->string('district', 60)->nullable();
            $table->string('sector', 60)->nullable();
            $table->string('phone_primary', 20);
            $table->string('phone_secondary', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('current_job_title', 100)->nullable();
            $table->enum('employment_status', [
                'employed',
                'unemployed',
                'self_employed',
                'inactive',
                'student'
            ])->default('unemployed');
            $table->text('professional_summary')->nullable();
            $table->json('languages')->nullable();
            $table->boolean('nida_verified')->default(false);
            $table->timestamp('nida_verified_at')->nullable();
            $table->string('nida_verification_ref')->nullable();
            $table->boolean('profile_complete')->default(false);
            $table->boolean('is_searchable')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
