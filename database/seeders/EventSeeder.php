<?php

namespace Database\Seeders;

use App\Models\Event;
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
        // Create some upcoming events
        $this->createEvent(
            'Annual Blood Donation Camp',
            'Join us for our annual blood donation camp. This event aims to collect blood donations to help those in need. Refreshments will be provided to all donors.',
            'City Community Center',
            Carbon::now()->addDays(15),
            Carbon::now()->addDays(15)->addHours(6),
            'active',
            true
        );
        
        $this->createEvent(
            'Blood Donation Awareness Program',
            'Learn about the importance of blood donation and how it saves lives. Healthcare professionals will be present to answer all your questions.',
            'Grand Hospital Auditorium',
            Carbon::now()->addDays(7),
            Carbon::now()->addDays(7)->addHours(3),
            'active',
            true
        );
        
        $this->createEvent(
            'University Blood Drive',
            'Calling all university students! Be a hero and donate blood at our campus blood drive. No appointment needed, just walk in.',
            'University Campus, Building B',
            Carbon::now()->addDays(21),
            Carbon::now()->addDays(21)->addHours(8),
            'active',
            false
        );
        
        // Create an ongoing event
        $this->createEvent(
            'Emergency Blood Donation',
            'Due to recent accidents, we are in urgent need of all blood types, especially O negative. Please come and donate if you can.',
            'Central Hospital',
            Carbon::now()->subHours(12),
            Carbon::now()->addDays(1),
            'active',
            true
        );
        
        // Create some past events
        $this->createEvent(
            'World Blood Donor Day Celebration',
            'We celebrated World Blood Donor Day with an event honoring regular donors and raising awareness about the importance of blood donation.',
            'Town Hall',
            Carbon::now()->subMonths(2),
            Carbon::now()->subMonths(2)->addHours(5),
            'active',
            false
        );
        
        $this->createEvent(
            'Corporate Blood Donation Drive',
            'Local businesses came together to encourage their employees to donate blood. Over 100 units of blood were collected during this successful event.',
            'Business District Convention Center',
            Carbon::now()->subMonths(1),
            Carbon::now()->subMonths(1)->addHours(9),
            'active',
            false
        );
    }
    
    /**
     * Create an event with the given details
     *
     * @param string $title
     * @param string $description
     * @param string $location
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param string $status
     * @param bool $isFeatured
     * @return Event
     */
    private function createEvent($title, $description, $location, $startDate, $endDate, $status, $isFeatured)
    {
        return Event::create([
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $description,
            'location' => $location,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'is_featured' => $isFeatured,
        ]);
    }
} 