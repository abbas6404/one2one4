<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('mood', ['donor', 'recipient'])->default('donor'); // Add mood column with default value
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])->nullable();
            $table->integer('total_blood_donation')->default(0);
            $table->year('ssc_exam_year')->nullable();
            $table->string('permanent_district')->nullable();
            $table->string('permanent_sub_district')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('present_district')->nullable();
            $table->string('present_sub_district')->nullable();
            $table->string('present_address')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('national_id')->nullable();
            $table->string('profile_picture')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->string('occupation')->nullable();
            $table->string('religion')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}