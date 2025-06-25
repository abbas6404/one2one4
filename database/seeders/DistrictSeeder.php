<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Division;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get divisions
        $dhakaDivision = Division::where('name', 'Dhaka')->first();
        $chittagongDivision = Division::where('name', 'Chittagong')->first();
        $rajshahiDivision = Division::where('name', 'Rajshahi')->first();
        $khulnaDivision = Division::where('name', 'Khulna')->first();
        $barisalDivision = Division::where('name', 'Barisal')->first();
        $sylhetDivision = Division::where('name', 'Sylhet')->first();
        $rangpurDivision = Division::where('name', 'Rangpur')->first();
        $mymensinghDivision = Division::where('name', 'Mymensingh')->first();

        $districts = [
            [
                'division_id' => $dhakaDivision->id,
                'name' => 'Dhaka',
                'bn_name' => 'ঢাকা'
            ],
            [
                'division_id' => $dhakaDivision->id,
                'name' => 'Gazipur',
                'bn_name' => 'গাজীপুর'
            ],
            [
                'division_id' => $dhakaDivision->id,
                'name' => 'Narayanganj',
                'bn_name' => 'নারায়ণগঞ্জ'
            ],
            [
                'division_id' => $chittagongDivision->id,
                'name' => 'Chittagong',
                'bn_name' => 'চট্টগ্রাম'
            ],
            [
                'division_id' => $chittagongDivision->id,
                'name' => 'Coxs Bazar',
                'bn_name' => 'কক্সবাজার'
            ],
            [
                'division_id' => $rajshahiDivision->id,
                'name' => 'Rajshahi',
                'bn_name' => 'রাজশাহী'
            ],
            [
                'division_id' => $khulnaDivision->id,
                'name' => 'Khulna',
                'bn_name' => 'খুলনা'
            ],
            [
                'division_id' => $barisalDivision->id,
                'name' => 'Barisal',
                'bn_name' => 'বরিশাল'
            ],
            [
                'division_id' => $sylhetDivision->id,
                'name' => 'Sylhet',
                'bn_name' => 'সিলেট'
            ],
            [
                'division_id' => $rangpurDivision->id,
                'name' => 'Rangpur',
                'bn_name' => 'রংপুর'
            ],
            [
                'division_id' => $mymensinghDivision->id,
                'name' => 'Mymensingh',
                'bn_name' => 'ময়মনসিংহ'
            ],
        ];

        foreach ($districts as $district) {
            District::create($district);
        }
    }
} 