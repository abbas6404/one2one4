<?php

namespace Database\Seeders;

use App\Models\BloodNotification;
use App\Models\BloodRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BloodNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users and blood requests for sample data
        $users = User::limit(5)->get();
        $bloodRequests = BloodRequest::limit(3)->get();
        
        if ($users->isEmpty() || $bloodRequests->isEmpty()) {
            $this->command->info('No users or blood requests found. Skipping notification seeding.');
            return;
        }
        
        foreach ($users as $user) {
            // Create donor assigned notification
            BloodNotification::create([
                'user_id' => $user->id,
                'blood_request_id' => $bloodRequests->random()->id,
                'donor_id' => $users->where('id', '!=', $user->id)->random()->id,
                'type' => 'donor_assigned',
                'message' => 'A donor has been assigned to your blood request.',
                'is_read' => rand(0, 1),
                'read_at' => rand(0, 1) ? Carbon::now() : null,
                'created_at' => Carbon::now()->subHours(rand(1, 24)),
            ]);
            
            // Create donation completed notification
            BloodNotification::create([
                'user_id' => $user->id,
                'blood_request_id' => $bloodRequests->random()->id,
                'donor_id' => null,
                'type' => 'donation_completed',
                'message' => 'Your blood donation has been successfully completed. Thank you!',
                'is_read' => rand(0, 1),
                'read_at' => rand(0, 1) ? Carbon::now() : null,
                'created_at' => Carbon::now()->subDays(rand(1, 7)),
            ]);
            
            // Create request updated notification
            BloodNotification::create([
                'user_id' => $user->id,
                'blood_request_id' => $bloodRequests->random()->id,
                'donor_id' => null,
                'type' => 'request_updated',
                'message' => 'Your blood request status has been updated.',
                'is_read' => rand(0, 1),
                'read_at' => rand(0, 1) ? Carbon::now() : null,
                'created_at' => Carbon::now()->subDays(rand(8, 14)),
            ]);
            
            // Create eligibility notification
            BloodNotification::create([
                'user_id' => $user->id,
                'blood_request_id' => null,
                'donor_id' => null,
                'type' => 'eligibility_update',
                'message' => 'You are now eligible to donate blood again. Your last donation was 4 months ago.',
                'is_read' => rand(0, 1),
                'read_at' => rand(0, 1) ? Carbon::now() : null,
                'created_at' => Carbon::now()->subDays(rand(15, 30)),
            ]);
        }
        
        $this->command->info('Sample notifications created successfully.');
    }
} 