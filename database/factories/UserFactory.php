<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Upazila;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random upazila ID or null if none exist
        $upazilaId = Upazila::count() > 0 ? Upazila::inRandomOrder()->first()->id : null;
        
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now()->addYear(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => '017' . fake()->numberBetween(10000000, 99999999),
            'dob' => fake()->dateTimeBetween('-40 years', '-18 years'),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'national_id' => fake()->numberBetween(1000000000, 9999999999),
            'marital_status' => fake()->randomElement(['single', 'married', 'divorced', 'widowed']),
            'occupation' => fake()->jobTitle(),
            'religion' => fake()->randomElement(['Islam', 'Christianity', 'Hinduism', 'Buddhism', 'Other']),
            'blood_group' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'total_blood_donation' => 0,
            'medical_conditions' => fake()->paragraph(),
            'last_donation_date' => null,
            'emergency_contact' => '014' . fake()->numberBetween(10000000, 99999999),
            'ssc_exam_year' => fake()->numberBetween(2000, date('Y')),
            'status' => 'active',
            'mode' => 'donor',
            'is_donor' => $this->faker->boolean(),
            'upazila_id' => $upazilaId,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}