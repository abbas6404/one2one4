<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Jane Smith',
                'content' => 'The blood donation saved my life after a serious accident. I\'m forever grateful to the donors who took the time to give blood. Now I\'m a regular donor myself to pay it forward.',
                'avatar' => 'images/testimonials/avatar.png',
                'blood_group' => 'B+',
                'type' => 'Blood Recipient',
                'location' => 'Dhaka',
                'status' => 'active',
                'order' => 1
            ],
            [
                'name' => 'John Doe',
                'content' => 'I donate blood regularly because I know it saves lives. The process is quick and easy, and the staff is always friendly and professional. I encourage everyone who can to donate.',
                'avatar' => 'images/testimonials/avatar.png',
                'blood_group' => 'O+',
                'type' => 'Blood Donor',
                'location' => 'Chittagong',
                'status' => 'active',
                'order' => 2
            ],
            [
                'name' => 'Rahul Khan',
                'content' => 'I was in desperate need of a rare blood type for my mother\'s surgery. Thanks to this community, we found a donor within hours!',
                'avatar' => 'images/testimonials/avatar.png',
                'blood_group' => 'AB-',
                'type' => 'Blood Recipient',
                'location' => 'Sylhet',
                'status' => 'active',
                'order' => 3
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
} 