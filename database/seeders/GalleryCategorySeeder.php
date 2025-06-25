<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Donation Camps',
            'Events',
            'Training',
            'Outreach Programs',
            'Meetings',
            'Workshops',
        ];

        foreach ($categories as $category) {
            GalleryCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'is_active' => true,
            ]);
        }
    }
} 