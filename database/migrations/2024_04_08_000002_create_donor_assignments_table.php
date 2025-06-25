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
        Schema::create('blood_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('blood_request_id')->constrained('blood_requests')->onDelete('cascade');
            $table->decimal('volume', 5, 2)->default(0.45); // in liters, default 450ml
            $table->enum('status', ['pending', 'confirmed', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('donation_date')->nullable();
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['donor_id', 'status']);
            $table->index(['blood_request_id', 'status']);
            $table->index('donation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_donations');
    }
}; 