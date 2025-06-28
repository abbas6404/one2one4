<?php

namespace Database\Seeders;

use App\Models\InternalProgram;
use App\Models\Event;
use App\Models\Upazila;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InternalProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::table('internal_programs')->truncate();

        // Get some events and upazilas for reference
        $events = Event::all();
        $upazilas = Upazila::all();
        
        if ($events->isEmpty() || $upazilas->isEmpty()) {
            $this->command->info('Events or Upazilas not found. Make sure to run EventSeeder and UpazilaSeeder first.');
            return;
        }

        // Sample data for internal program registrations
        $internalPrograms = [
            [
                'name' => 'Rafiqul Islam',
                'phone' => '01712345678',
                'email' => 'rafiq@example.com',
                'blood_group' => 'A+',
                'upazila_id' => $upazilas->random()->id,
                'tshirt_size' => 'L',
                'payment_method' => 'bKash',
                'payment_amount' => '500',
                'event_id' => $events->random()->id,
                'trx_id' => 'TRX' . rand(1000000, 9999999),
                'screenshot' => 'images/internal_programs/sample_screenshot_1.jpg',
                'status' => 'approved',
                'created_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'name' => 'Nusrat Jahan',
                'phone' => '01812345678',
                'email' => 'nusrat@example.com',
                'blood_group' => 'B+',
                'upazila_id' => $upazilas->random()->id,
                'tshirt_size' => 'M',
                'payment_method' => 'Nagad',
                'payment_amount' => '500',
                'event_id' => $events->random()->id,
                'trx_id' => 'TRX' . rand(1000000, 9999999),
                'screenshot' => 'images/internal_programs/sample_screenshot_2.jpg',
                'status' => 'approved',
                'created_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'name' => 'Kamal Hossain',
                'phone' => '01912345678',
                'email' => 'kamal@example.com',
                'blood_group' => 'O+',
                'upazila_id' => $upazilas->random()->id,
                'tshirt_size' => 'XL',
                'payment_method' => 'Rocket',
                'payment_amount' => '500',
                'event_id' => $events->random()->id,
                'trx_id' => 'TRX' . rand(1000000, 9999999),
                'screenshot' => 'images/internal_programs/sample_screenshot_3.jpg',
                'status' => 'pending',
                'created_at' => now()->subDays(rand(1, 10)),
            ],
            [
                'name' => 'Farida Begum',
                'phone' => '01612345678',
                'email' => null,
                'blood_group' => 'AB+',
                'upazila_id' => $upazilas->random()->id,
                'tshirt_size' => 'S',
                'payment_method' => 'Cash',
                'payment_amount' => '500',
                'event_id' => null,
                'trx_id' => null,
                'screenshot' => null,
                'status' => 'pending',
                'created_at' => now()->subDays(rand(1, 5)),
            ],
            [
                'name' => 'Jamal Uddin',
                'phone' => '01512345678',
                'email' => 'jamal@example.com',
                'blood_group' => 'A-',
                'upazila_id' => $upazilas->random()->id,
                'tshirt_size' => 'XXL',
                'payment_method' => 'Bank Transfer',
                'payment_amount' => '500',
                'event_id' => $events->random()->id,
                'trx_id' => 'TRX' . rand(1000000, 9999999),
                'screenshot' => 'images/internal_programs/sample_screenshot_5.jpg',
                'status' => 'rejected',
                'created_at' => now()->subDays(rand(15, 45)),
            ],
        ];

        // Insert the data
        foreach ($internalPrograms as $program) {
            InternalProgram::create($program);
        }
        
        $this->command->info('Internal Program data seeded successfully.');
    }
}
