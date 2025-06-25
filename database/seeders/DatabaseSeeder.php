<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            // First seed locations
            DivisionSeeder::class,
            DistrictSeeder::class,
            UpazilaSeeder::class,
            
            // Then seed users and related data
            UserSeeder::class,
            BloodRequestSeeder::class,
            BloodDonationSeeder::class,
            
            // Finally seed admin and permissions
            AdminSeeder::class,
            RolePermissionSeeder::class,
            WebsiteContentSeeder::class,
            
            // Sponsors
            SponsorSeeder::class,
            
            // Testimonials
            TestimonialSeeder::class,
            
            // Gallery
            GalleryCategorySeeder::class,
            GallerySeeder::class,
            GalleryImageSeeder::class,
            
            // Events
            EventSeeder::class,
        ]);
    }
}
