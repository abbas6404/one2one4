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
        Schema::create('blood_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blood_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('donor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('type', ['donor_assigned', 'request_approved', 'donation_completed', 'request_updated']);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['user_id', 'is_read']);
            $table->index(['blood_request_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_notifications');
    }
}; 