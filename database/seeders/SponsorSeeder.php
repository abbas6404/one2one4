<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sponsor;
use Illuminate\Support\Facades\DB;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing sponsors
        DB::table('sponsors')->truncate();
        
        $sponsors = [
            [
                'name' => 'Medical Center Hospital',
                'logo' => 'images/sponsors/sponsor1.png',
                'url' => 'https://example.com/hospital',
                'status' => 'active',
                'order' => 1
            ],
            [
                'name' => 'LifeStream Blood Bank',
                'logo' => 'images/sponsors/sponsor2.png',
                'url' => 'https://example.com/lifestream',
                'status' => 'active',
                'order' => 2
            ],
            [
                'name' => 'Red Cross Society',
                'logo' => 'images/sponsors/sponsor3.png',
                'url' => 'https://example.com/redcross',
                'status' => 'active',
                'order' => 3
            ],
            [
                'name' => 'City Health Foundation',
                'logo' => 'images/sponsors/sponsor4.png',
                'url' => 'https://example.com/health',
                'status' => 'active',
                'order' => 4
            ],
            [
                'name' => 'National Blood Bank',
                'logo' => 'images/sponsors/sponsor5.png',
                'url' => 'https://example.com/bloodbank',
                'status' => 'active',
                'order' => 5
            ],
            [
                'name' => 'Blood Donors Association',
                'logo' => 'images/sponsors/sponsor6.png',
                'url' => 'https://example.com/blooddonors',
                'status' => 'active',
                'order' => 6
            ],
            [
                'name' => 'Global Blood Fund',
                'logo' => 'images/sponsors/sponsor7.png',
                'url' => 'https://example.com/globalbloodfund',
                'status' => 'active',
                'order' => 7
            ],
            [
                'name' => 'Blood Alliance',
                'logo' => 'images/sponsors/sponsor8.png',
                'url' => 'https://example.com/bloodalliance',
                'status' => 'active',
                'order' => 8
            ],
            [
                'name' => 'Blood Donors Association',
                'logo' => 'images/sponsors/sponsor9.png',
                'url' => 'https://example.com/blooddonors',
                'status' => 'active',
                'order' => 9
            ],
            [
                'name' => 'Blood Donors Association',
                'logo' => 'images/sponsors/sponsor10.png',
                'url' => 'https://example.com/blooddonors',
                'status' => 'active',
                'order' => 10
            ],
            [
                'name' => 'AIO Innovations Ltd',
                'logo' => 'images/sponsors/sponsor1.png',
                'url' => 'https://example.com/blooddonors',
                'status' => 'active',
                'order' => 11
            ]
        ];

        foreach ($sponsors as $sponsor) {
            Sponsor::create($sponsor);
        }
    }
}
