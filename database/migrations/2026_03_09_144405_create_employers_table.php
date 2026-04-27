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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // employer user account
            $table->string('name');
            $table->string('tin_number')->unique();           // Tax Identification Number
            $table->string('registration_number')->unique();  // RDB registration number
            $table->enum('sector', [
                'public_administration', 'banking_finance', 'hospitality_tourism',
                'bpo_call_center', 'healthcare', 'education', 'manufacturing',
                'construction', 'agriculture', 'ngo', 'technology', 'retail', 'other'
            ])->default('other');
            $table->string('address');
            $table->string('district');
            $table->string('province');
            $table->string('phone');
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['pending', 'verified', 'suspended', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->string('verified_by')->nullable(); // government official name/id
            $table->timestamp('verified_at')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
