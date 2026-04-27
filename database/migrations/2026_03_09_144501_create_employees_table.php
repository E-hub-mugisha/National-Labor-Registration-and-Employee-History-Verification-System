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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // linked user account
            $table->string('national_id', 16)->unique(); // Rwanda NID: 16 digits
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('current_employer_id')->nullable()->constrained('employers')->onDelete('set null');
            $table->enum('status', ['active', 'unemployed', 'blacklisted'])->default('unemployed');
            $table->text('skills')->nullable(); // JSON or comma-separated
            $table->string('highest_qualification')->nullable();
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
