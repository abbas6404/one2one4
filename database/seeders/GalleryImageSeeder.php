<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all galleries
        $galleries = Gallery::all();
        
        foreach ($galleries as $gallery) {
            // Main image is already stored in the gallery record
            // Add 2-4 additional images for each gallery
            $numImages = rand(2, 4);
            
            for ($i = 1; $i <= $numImages; $i++) {
                // Extract base image name without extension
                $basePath = pathinfo($gallery->image, PATHINFO_DIRNAME);
                $baseFileName = pathinfo($gallery->image, PATHINFO_FILENAME);
                $extension = pathinfo($gallery->image, PATHINFO_EXTENSION);
                
                // Create a variation of the image name (e.g. donation-camp-1-2.jpg)
                $newImageName = $basePath . '/' . $baseFileName . '-' . $i . '.' . $extension;
                
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => $newImageName,
                    'sort_order' => $i,
                    'is_active' => true
                ]);
            }
        }
    }
} 