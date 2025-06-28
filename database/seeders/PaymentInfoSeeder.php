<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteContent;

class PaymentInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Payment Information
        $paymentInfo = [
            [
                'key' => 'payment.bKash.number',
                'content' => '01712345678',
                'is_active' => true,
            ],
            [
                'key' => 'payment.bKash.type',
                'content' => 'Personal',
                'is_active' => true,
            ],
            [
                'key' => 'payment.Nagad.number',
                'content' => '01812345678',
                'is_active' => true,
            ],
            [
                'key' => 'payment.Nagad.type',
                'content' => 'Personal',
                'is_active' => true,
            ],
            [
                'key' => 'payment.Rocket.number',
                'content' => '01912345678',
                'is_active' => true,
            ],
            [
                'key' => 'payment.Rocket.type',
                'content' => 'Personal',
                'is_active' => true,
            ],
            [
                'key' => 'payment.Bank_Transfer.details',
                'content' => json_encode([
                    'bank_name' => 'Dutch-Bangla Bank Limited',
                    'account_name' => 'One2One4 Blood Donation',
                    'account_number' => '123456789012',
                    'branch' => 'Dhanmondi Branch'
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($paymentInfo as $info) {
            WebsiteContent::updateOrCreate(
                ['key' => $info['key']],
                $info
            );
        }
    }
} 