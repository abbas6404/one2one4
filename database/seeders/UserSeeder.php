<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Upazila;
use App\Models\Admin;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Get all upazilas for random assignment
        $upazilas = Upazila::all();
        
        if ($upazilas->isEmpty()) {
            $this->command->error('No upazilas found. Please run the UpazilaSeeder first.');
            return;
        }
        
        // Get admin for created_by field
        $admin = Admin::first();
        
        // Create 10 test users
        User::factory(10)->create([
            'created_by' => $admin ? $admin->id : null,
            'upazila_id' => function() use ($upazilas) {
                return $upazilas->random()->id;
            }
        ]);

        // Create a test user with known credentials
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'phone' => '01712345678',
            'blood_group' => 'A+',
            'gender' => 'male',
            'dob' => '1990-01-01',
            'is_donor' => true,
            'registration_step' => 3,
            'profile_completed' => true,
            'upazila_id' => $upazilas->random()->id,
            'created_by' => $admin ? $admin->id : null,
            'ssc_exam_year' => 2010,
        ]);

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '01712345679',
            'blood_group' => 'O+',
            'gender' => 'male',
            'mode' => 'donor',
            'status' => 'active',
            'email_verified_at' => now(),
            'upazila_id' => $upazilas->random()->id,
            'created_by' => $admin ? $admin->id : null,
            'ssc_exam_year' => 2008,
        ]);

        // Create sample donor users
        User::factory(10)->create([
            'mode' => 'donor',
            'status' => 'active',
            'created_by' => $admin ? $admin->id : null,
            'upazila_id' => function() use ($upazilas) {
                return $upazilas->random()->id;
            }
        ]);

        // Create sample recipient users
        User::factory(5)->create([
            'mode' => 'recipient',
            'status' => 'active',
            'created_by' => $admin ? $admin->id : null,
            'upazila_id' => function() use ($upazilas) {
                return $upazilas->random()->id;
            }
        ]);

        $this->command->info('Users table seeded successfully!');
        $this->command->info('Admin credentials:');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
    }
}
