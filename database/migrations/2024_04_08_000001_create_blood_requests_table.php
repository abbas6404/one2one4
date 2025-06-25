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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('blood_type');
            $table->integer('units_needed');
            $table->enum('urgency_level', ['normal', 'urgent'])->default('normal');
            $table->string('hospital_name');
            $table->text('hospital_address')->nullable();
            $table->date('needed_date')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'cancel'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('hospital_division_id')->nullable()->constrained('divisions');
            $table->foreignId('hospital_district_id')->nullable()->constrained('districts');
            $table->foreignId('hospital_upazila_id')->nullable()->constrained('upazilas');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
}; 