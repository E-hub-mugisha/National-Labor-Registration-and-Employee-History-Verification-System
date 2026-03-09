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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('rdb_number', 50)->unique();
            $table->string('company_name', 200);
            $table->string('trading_name', 200)->nullable();
            $table->enum('business_type', [
                'sole_proprietorship',
                'partnership',
                'limited_company',
                'public_institution',
                'ngo',
                'cooperative',
                'other'
            ]);
            $table->string('industry_sector', 100);
            $table->text('company_description')->nullable();
            $table->string('website', 200)->nullable();
            $table->string('headquarters_province', 60);
            $table->string('headquarters_district', 60);
            $table->string('headquarters_address')->nullable();
            $table->string('contact_phone', 20);
            $table->string('contact_email');
            $table->string('hr_contact_name', 100)->nullable();
            $table->string('hr_contact_phone', 20)->nullable();
            $table->string('hr_contact_email')->nullable();
            $table->enum('verification_status', [
                'pending',
                'verified',
                'rejected',
                'suspended'
            ])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->string('rdb_verification_ref')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->enum('subscription_tier', [
                'basic',
                'standard',
                'premium'
            ])->default('basic');
            $table->integer('monthly_search_quota')->default(50);
            $table->integer('searches_used_this_month')->default(0);
            $table->date('quota_reset_date')->nullable();
            $table->string('company_logo')->nullable();
            $table->boolean('is_active')->default(true);
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
