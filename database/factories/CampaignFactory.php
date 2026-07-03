<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->randomNumber(4),
            'description' => fake()->optional()->paragraphs(3, true),
            'image_path' => null,
            'target_amount' => fake()->numberBetween(1_000_000, 100_000_000),
            'deadline' => fake()->dateTimeBetween('+1 day', '+60 days')->format('Y-m-d'),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (): array => [
            'deadline' => fake()->dateTimeBetween('-30 days', '-1 day')->format('Y-m-d'),
        ]);
    }
}
