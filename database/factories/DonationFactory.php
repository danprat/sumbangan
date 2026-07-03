<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::factory(),
            'token' => (string) Str::orderedUuid(),
            'donor_name' => fake()->name(),
            'donor_email' => fake()->optional()->safeEmail(),
            'donor_phone' => fake()->optional()->phoneNumber(),
            'amount' => fake()->numberBetween(10_000, 5_000_000),
            'proof_image_path' => 'donations/test-proof.png',
            'status' => 'pending',
            'admin_notes' => null,
            'verified_at' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (): array => [
            'status' => 'pending',
            'verified_at' => null,
        ]);
    }

    public function verified(): static
    {
        return $this->state(fn (): array => [
            'status' => 'verified',
            'verified_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (): array => [
            'status' => 'rejected',
            'admin_notes' => fake()->sentence(),
        ]);
    }
}
