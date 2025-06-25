<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryItems = [
            [
                'title' => 'Blood Donation Camp at Dhaka University',
                'description' => 'Our team organized a successful blood donation camp at Dhaka University where over 50 students donated blood.',
                'image' => 'images/gallery/donation-camp-1.jpg',
                'category' => 'donation-camps',
                'date' => '2023-12-15',
            ],
            [
                'title' => 'World Blood Donor Day Celebration',
                'description' => 'Celebrating World Blood Donor Day with our amazing donors and volunteers.',
                'image' => 'images/gallery/world-donor-day.jpg',
                'category' => 'events',
                'date' => '2023-06-14',
            ],
            [
                'title' => 'Volunteer Training Session',
                'description' => 'Training our dedicated volunteers on blood donation protocols and donor care.',
                'image' => 'images/gallery/volunteer-training.jpg',
                'category' => 'training',
                'date' => '2023-09-22',
            ],
            [
                'title' => 'Rural Outreach Program',
                'description' => 'Reaching out to rural communities to spread awareness about blood donation and its benefits.',
                'image' => 'images/gallery/rural-outreach.jpg',
                'category' => 'outreach-programs',
                'date' => '2023-07-10',
            ],
            [
                'title' => 'Hospital Collaboration Meeting',
                'description' => 'Meeting with hospital administrators to strengthen our partnership for blood supply.',
                'image' => 'images/gallery/hospital-meeting.jpg',
                'category' => 'meetings',
                'date' => '2023-08-05',
            ],
            [
                'title' => 'Blood Donation Awareness Workshop',
                'description' => 'Conducting workshops to educate people about the importance of regular blood donation.',
                'image' => 'images/gallery/awareness-workshop.jpg',
                'category' => 'workshops',
                'date' => '2023-10-18',
            ],
            [
                'title' => 'Corporate Blood Drive',
                'description' => 'Partnering with local corporations to organize blood drives for their employees.',
                'image' => 'images/gallery/corporate-drive.jpg',
                'category' => 'donation-camps',
                'date' => '2023-11-25',
            ],
            [
                'title' => 'Blood Donation Camp at Local School',
                'description' => 'Organizing a blood donation awareness program and camp at a local school.',
                'image' => 'images/gallery/school-camp.jpg',
                'category' => 'donation-camps',
                'date' => '2024-01-20',
            ],
            [
                'title' => 'First Aid Training for Volunteers',
                'description' => 'Training our volunteers in basic first aid to better assist during donation camps.',
                'image' => 'images/gallery/first-aid.jpg',
                'category' => 'training',
                'date' => '2024-02-12',
            ],
            [
                'title' => 'Annual Donor Recognition Event',
                'description' => 'Recognizing and celebrating our regular donors who have made significant contributions.',
                'image' => 'images/gallery/donor-recognition.jpg',
                'category' => 'events',
                'date' => '2023-12-30',
            ],
            [
                'title' => 'Mobile Blood Donation Van Launch',
                'description' => 'Launching our new mobile blood donation van to reach more communities.',
                'image' => 'images/gallery/mobile-van.jpg',
                'category' => 'events',
                'date' => '2024-03-05',
            ],
            [
                'title' => 'Blood Group Testing Camp',
                'description' => 'Free blood group testing camp organized in collaboration with local clinics.',
                'image' => 'images/gallery/blood-testing.jpg',
                'category' => 'outreach-programs',
                'date' => '2024-02-28',
            ]
        ];

        foreach ($galleryItems as $item) {
            $category = GalleryCategory::where('slug', $item['category'])->first();
            
            if ($category) {
                Gallery::create([
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'category_id' => $category->id,
                    'image' => $item['image'],
                    'is_active' => true,
                ]);
            }
        }
    }
} 