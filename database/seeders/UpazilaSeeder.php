<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Upazila;
use Illuminate\Database\Seeder;

class UpazilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dhaka District Upazilas
        $dhaka = District::where('name', 'Dhaka')->first();
        $dhakaUpazilas = [
            [
                'name' => 'Dhanmondi',
                'bn_name' => 'ধানমন্ডি'
            ],
            [
                'name' => 'Mirpur',
                'bn_name' => 'মিরপুর'
            ],
            [
                'name' => 'Mohammadpur',
                'bn_name' => 'মোহাম্মদপুর'
            ],
            [
                'name' => 'Gulshan',
                'bn_name' => 'গুলশান'
            ],
            [
                'name' => 'Uttara',
                'bn_name' => 'উত্তরা'
            ],
        ];

        foreach ($dhakaUpazilas as $upazila) {
            $dhaka->upazilas()->create($upazila);
        }

        // Chittagong District Upazilas
        $chittagong = District::where('name', 'Chittagong')->first();
        $chittagongUpazilas = [
            [
                'name' => 'Agrabad',
                'bn_name' => 'আগ্রাবাদ'
            ],
            [
                'name' => 'Halishahar',
                'bn_name' => 'হালিশহর'
            ],
            [
                'name' => 'Patenga',
                'bn_name' => 'পতেঙ্গা'
            ],
        ];

        foreach ($chittagongUpazilas as $upazila) {
            $chittagong->upazilas()->create($upazila);
        }

        // Sylhet District Upazilas
        $sylhet = District::where('name', 'Sylhet')->first();
        $sylhetUpazilas = [
            [
                'name' => 'Sylhet Sadar',
                'bn_name' => 'সিলেট সদর'
            ],
            [
                'name' => 'Golapganj',
                'bn_name' => 'গোলাপগঞ্জ'
            ],
            [
                'name' => 'Beanibazar',
                'bn_name' => 'বিয়ানীবাজার'
            ],
        ];

        foreach ($sylhetUpazilas as $upazila) {
            $sylhet->upazilas()->create($upazila);
        }

        // Rajshahi District Upazilas
        $rajshahi = District::where('name', 'Rajshahi')->first();
        $rajshahiUpazilas = [
            [
                'name' => 'Boalia',
                'bn_name' => 'বোয়ালিয়া'
            ],
            [
                'name' => 'Motihar',
                'bn_name' => 'মতিহার'
            ],
            [
                'name' => 'Rajpara',
                'bn_name' => 'রাজপাড়া'
            ],
        ];

        foreach ($rajshahiUpazilas as $upazila) {
            $rajshahi->upazilas()->create($upazila);
        }
    }
} 