<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BloodRequest;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BloodRequestSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_donor', false)->get();
        
        // If no non-donor users exist, create some
        if ($users->isEmpty()) {
            $users = User::factory(5)->create(['is_donor' => false]);
        }

        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $hospitals = [
            'City General Hospital',
            'St. Mary Medical Center',
            'Central Hospital',
            'Unity Healthcare',
            'Metropolitan Hospital'
        ];

        for ($i = 0; $i < 10; $i++) {
            $status = fake()->randomElement([
                BloodRequest::STATUS_PENDING,
                BloodRequest::STATUS_APPROVED,
                BloodRequest::STATUS_REJECTED,
                BloodRequest::STATUS_COMPLETED
            ]);

            BloodRequest::create([
                'user_id' => $users->random()->id,
                'blood_type' => fake()->randomElement($bloodGroups),
                'units_needed' => fake()->numberBetween(1, 5),
                'hospital_name' => fake()->randomElement($hospitals),
                'hospital_address' => fake()->address(),
                'urgency_level' => fake()->randomElement(['normal', 'urgent']),
                'needed_date' => Carbon::now()->addDays(fake()->numberBetween(1, 30)),
                'additional_notes' => fake()->optional()->sentence(),
                'status' => $status,
                'rejection_reason' => $status === BloodRequest::STATUS_REJECTED ? fake()->sentence() : null,
            ]);
        }
    }
} 