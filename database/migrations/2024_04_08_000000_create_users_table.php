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
        Schema::create('users', function (Blueprint $table) {
            // Basic Information
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('is_donor')->default(true);
            $table->integer('registration_step')->default(1);
            $table->boolean('profile_completed')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            // Contact Information
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            
            // Profile Information
            $table->string('profile_picture')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('national_id')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            
            // Professional Information
            $table->string('occupation')->nullable();
            $table->string('religion')->nullable();
            
            // Blood Donation Information
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])->nullable();
            $table->integer('total_blood_donation')->default(0);
            $table->text('medical_conditions')->nullable();
            $table->timestamp('last_donation_date')->nullable();
            $table->string('emergency_contact')->nullable();
            
            // Education Information
            $table->year('ssc_exam_year')->nullable();
            
            // Account Status
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('mode', ['donor', 'recipient'])->default('donor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}; 