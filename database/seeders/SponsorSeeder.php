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
                'phone' => '01712345678',
                'email' => 'medical@example.com',
                'payment_method' => 'bKash',
                'payment_status' => 'completed',
                'payment_amount' => '5000',
                'payment_screenshot' => 'images/sponsors/payments/payment1.png',
                'payment_transaction_id' => 'TRX123456789',
                'status' => 'active',
                'order' => 1
            ],
            [
                'name' => 'LifeStream Blood Bank',
                'logo' => 'images/sponsors/sponsor2.png',
                'url' => 'https://example.com/lifestream',
                'phone' => '01812345678',
                'email' => 'lifestream@example.com',
                'payment_method' => 'Nagad',
                'payment_status' => 'completed',
                'payment_amount' => '7500',
                'payment_screenshot' => 'images/sponsors/payments/payment2.png',
                'payment_transaction_id' => 'TRX987654321',
                'status' => 'active',
                'order' => 2
            ],
            [
                'name' => 'Red Cross Society',
                'logo' => 'images/sponsors/sponsor3.png',
                'url' => 'https://example.com/redcross',
                'phone' => '01912345678',
                'email' => 'redcross@example.com',
                'payment_method' => 'Bank Transfer',
                'payment_status' => 'completed',
                'payment_amount' => '10000',
                'payment_screenshot' => 'images/sponsors/payments/payment3.png',
                'payment_transaction_id' => 'TRX456789123',
                'status' => 'active',
                'order' => 3
            ],
            [
                'name' => 'City Health Foundation',
                'logo' => 'images/sponsors/sponsor4.png',
                'url' => 'https://example.com/health',
                'phone' => '01612345678',
                'email' => 'cityhealth@example.com',
                'payment_method' => 'bKash',
                'payment_status' => 'completed',
                'payment_amount' => '5000',
                'payment_screenshot' => 'images/sponsors/payments/payment4.png',
                'payment_transaction_id' => 'TRX789123456',
                'status' => 'active',
                'order' => 4
            ],
            [
                'name' => 'National Blood Bank',
                'logo' => 'images/sponsors/sponsor5.png',
                'url' => 'https://example.com/bloodbank',
                'phone' => '01512345678',
                'email' => 'nationalblood@example.com',
                'payment_method' => 'Rocket',
                'payment_status' => 'completed',
                'payment_amount' => '7500',
                'payment_screenshot' => 'images/sponsors/payments/payment5.png',
                'payment_transaction_id' => 'TRX321654987',
                'status' => 'active',
                'order' => 5
            ],
            [
                'name' => 'Blood Donors Association',
                'logo' => 'images/sponsors/sponsor6.png',
                'url' => 'https://example.com/blooddonors',
                'phone' => '01312345678',
                'email' => 'donors@example.com',
                'payment_method' => 'Cash',
                'payment_status' => 'completed',
                'payment_amount' => '5000',
                'payment_screenshot' => 'images/sponsors/payments/payment6.png',
                'payment_transaction_id' => null,
                'status' => 'active',
                'order' => 6
            ],
            [
                'name' => 'Global Blood Fund',
                'logo' => 'images/sponsors/sponsor7.png',
                'url' => 'https://example.com/globalbloodfund',
                'phone' => '01412345678',
                'email' => 'globalfund@example.com',
                'payment_method' => 'bKash',
                'payment_status' => 'pending',
                'payment_amount' => '10000',
                'payment_screenshot' => 'images/sponsors/payments/payment7.png',
                'payment_transaction_id' => 'TRX654987321',
                'status' => 'inactive',
                'order' => 7
            ],
            [
                'name' => 'Blood Alliance',
                'logo' => 'images/sponsors/sponsor8.png',
                'url' => 'https://example.com/bloodalliance',
                'phone' => '01212345678',
                'email' => 'alliance@example.com',
                'payment_method' => 'Nagad',
                'payment_status' => 'completed',
                'payment_amount' => '7500',
                'payment_screenshot' => 'images/sponsors/payments/payment8.png',
                'payment_transaction_id' => 'TRX159753486',
                'status' => 'active',
                'order' => 8
            ],
            [
                'name' => 'AIO Innovations Ltd',
                'logo' => 'images/sponsors/sponsor1.png',
                'url' => 'https://example.com/aio',
                'phone' => '01712345679',
                'email' => 'aio@example.com',
                'payment_method' => 'Bank Transfer',
                'payment_status' => 'completed',
                'payment_amount' => '15000',
                'payment_screenshot' => 'images/sponsors/payments/payment9.png',
                'payment_transaction_id' => 'TRX753159486',
                'status' => 'active',
                'order' => 9
            ]
        ];

        foreach ($sponsors as $sponsor) {
            Sponsor::create($sponsor);
        }
        
        $this->command->info('Sponsors seeded successfully!');
    }
}
