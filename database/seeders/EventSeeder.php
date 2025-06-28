<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Upazila;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get a random upazila for events
        $upazilas = Upazila::all();
        
        if ($upazilas->isEmpty()) {
            $this->command->error('No upazilas found. Please run the UpazilaSeeder first.');
            return;
        }
        
        // Create some upcoming events
        $this->createEvent(
            'Annual Blood Donation Camp',
            'Join us for our annual blood donation camp. This event aims to collect blood donations to help those in need. Refreshments will be provided to all donors.',
            $upazilas->random()->id,
            Carbon::now()->addDays(15),
            Carbon::now()->addDays(15)->addHours(6),
            'active',
            true,
            '500'
        );
        
        $this->createEvent(
            'Blood Donation Awareness Program',
            'Learn about the importance of blood donation and how it saves lives. Healthcare professionals will be present to answer all your questions.',
            $upazilas->random()->id,
            Carbon::now()->addDays(7),
            Carbon::now()->addDays(7)->addHours(3),
            'active',
            true,
            '300'
        );
        
        $this->createEvent(
            'University Blood Drive',
            'Calling all university students! Be a hero and donate blood at our campus blood drive. No appointment needed, just walk in.',
            $upazilas->random()->id,
            Carbon::now()->addDays(21),
            Carbon::now()->addDays(21)->addHours(8),
            'active',
            false,
            '200'
        );
        
        // Create an ongoing event
        $this->createEvent(
            'Emergency Blood Donation',
            'Due to recent accidents, we are in urgent need of all blood types, especially O negative. Please come and donate if you can.',
            $upazilas->random()->id,
            Carbon::now()->subHours(12),
            Carbon::now()->addDays(1),
            'active',
            true,
            '0'
        );
        
        // Create some past events
        $this->createEvent(
            'World Blood Donor Day Celebration',
            'We celebrated World Blood Donor Day with an event honoring regular donors and raising awareness about the importance of blood donation.',
            $upazilas->random()->id,
            Carbon::now()->subMonths(2),
            Carbon::now()->subMonths(2)->addHours(5),
            'active',
            false,
            '100'
        );
        
        $this->createEvent(
            'Corporate Blood Donation Drive',
            'Local businesses came together to encourage their employees to donate blood. Over 100 units of blood were collected during this successful event.',
            $upazilas->random()->id,
            Carbon::now()->subMonths(1),
            Carbon::now()->subMonths(1)->addHours(9),
            'active',
            false,
            '250'
        );
        
        $this->command->info('Events seeded successfully!');
    }
    
    /**
     * Create an event with the given details
     *
     * @param string $title
     * @param string $description
     * @param int $upazilaId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param string $status
     * @param bool $isFeatured
     * @param string $eventFee
     * @return Event
     */
    private function createEvent($title, $description, $upazilaId, $startDate, $endDate, $status, $isFeatured, $eventFee)
    {
        return Event::create([
            'title' => $title,
            'description' => $description,
            'upazila_id' => $upazilaId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'is_featured' => $isFeatured,
            'event_fee' => $eventFee,
            'image' => 'images/events/event' . rand(1, 6) . '.jpg',
        ]);
    }
} 