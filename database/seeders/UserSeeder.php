<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Location;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Create 10 test users
        User::factory(10)->create()->each(function ($user) {
            // Create permanent and present locations for each user
            Location::create([
                'user_id' => $user->id,
                'type' => 'permanent',
                'address' => fake()->address,
            ]);
            
            Location::create([
                'user_id' => $user->id,
                'type' => 'present',
                'address' => fake()->address,
            ]);
        });

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
        ]);

        // Create locations for test user
        Location::create([
            'user_id' => $testUser->id,
            'type' => 'permanent',
            'address' => 'Test Permanent Address',
        ]);
        
        Location::create([
            'user_id' => $testUser->id,
            'type' => 'present',
            'address' => 'Test Present Address',
        ]);

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '01712345678',
            'blood_group' => 'O+',
            'gender' => 'male',
            'mode' => 'donor',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create locations for admin user
        Location::create([
            'user_id' => $adminUser->id,
            'type' => 'permanent',
            'address' => 'Admin Permanent Address',
        ]);
        
        Location::create([
            'user_id' => $adminUser->id,
            'type' => 'present',
            'address' => 'Admin Present Address',
        ]);

        // Create sample donor users
        User::factory(10)->create([
            'mode' => 'donor',
            'status' => 'active',
        ])->each(function ($user) {
            Location::create([
                'user_id' => $user->id,
                'type' => 'permanent',
                'address' => fake()->address,
            ]);
            
            Location::create([
                'user_id' => $user->id,
                'type' => 'present',
                'address' => fake()->address,
            ]);
        });

        // Create sample recipient users
        User::factory(5)->create([
            'mode' => 'recipient',
            'status' => 'active',
        ])->each(function ($user) {
            Location::create([
                'user_id' => $user->id,
                'type' => 'permanent',
                'address' => fake()->address,
            ]);
            
            Location::create([
                'user_id' => $user->id,
                'type' => 'present',
                'address' => fake()->address,
            ]);
        });

        $this->command->info('Users table seeded successfully!');
        $this->command->info('Admin credentials:');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
    }
}
