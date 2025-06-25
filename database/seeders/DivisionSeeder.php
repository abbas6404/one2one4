<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'Dhaka',
                'bn_name' => 'ঢাকা'
            ],
            [
                'name' => 'Chittagong',
                'bn_name' => 'চট্টগ্রাম'
            ],
            [
                'name' => 'Rajshahi',
                'bn_name' => 'রাজশাহী'
            ],
            [
                'name' => 'Khulna',
                'bn_name' => 'খুলনা'
            ],
            [
                'name' => 'Barisal',
                'bn_name' => 'বরিশাল'
            ],
            [
                'name' => 'Sylhet',
                'bn_name' => 'সিলেট'
            ],
            [
                'name' => 'Rangpur',
                'bn_name' => 'রংপুর'
            ],
            [
                'name' => 'Mymensingh',
                'bn_name' => 'ময়মনসিংহ'
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
} 