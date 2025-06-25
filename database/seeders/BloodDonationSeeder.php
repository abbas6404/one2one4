<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BloodRequest;
use App\Models\BloodDonation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BloodDonationSeeder extends Seeder
{
    public function run(): void
    {
        $donors = User::where('is_donor', true)->get();
        
        // If no donors exist, create some
        if ($donors->isEmpty()) {
            $donors = User::factory(5)->create(['is_donor' => true]);
        }

        // Get pending and approved blood requests
        $requests = BloodRequest::whereIn('status', [
            BloodRequest::STATUS_PENDING,
            BloodRequest::STATUS_APPROVED
        ])->get();
        
        // If no pending/approved requests exist, create some
        if ($requests->isEmpty()) {
            $this->call(BloodRequestSeeder::class);
            $requests = BloodRequest::whereIn('status', [
                BloodRequest::STATUS_PENDING,
                BloodRequest::STATUS_APPROVED
            ])->get();
        }

        // Create donations
        for ($i = 0; $i < 10; $i++) {
            $request = $requests->random();
            $status = fake()->randomElement([
                BloodDonation::STATUS_PENDING,
                BloodDonation::STATUS_APPROVED,
                BloodDonation::STATUS_REJECTED,
                BloodDonation::STATUS_COMPLETED
            ]);
            
            BloodDonation::create([
                'donor_id' => $donors->random()->id,
                'blood_request_id' => $request->id,
                'volume' => 0.45, // 450ml
                'status' => $status,
                'rejection_reason' => $status === BloodDonation::STATUS_REJECTED ? fake()->sentence() : null,
                'donation_date' => $status === BloodDonation::STATUS_COMPLETED ? 
                    Carbon::now()->subDays(fake()->numberBetween(1, 30)) : 
                    ($status === BloodDonation::STATUS_PENDING ? Carbon::now()->addDays(fake()->numberBetween(1, 7)) : null),
            ]);

            // Update request status if all donations are complete
            if ($status === BloodDonation::STATUS_COMPLETED) {
                $completedDonations = BloodDonation::where('blood_request_id', $request->id)
                    ->where('status', BloodDonation::STATUS_COMPLETED)
                    ->count();
                
                if ($completedDonations >= $request->units_needed) {
                    $request->update(['status' => BloodRequest::STATUS_COMPLETED]);
                }
            }
        }
    }
} 