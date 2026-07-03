<?php

namespace Tests\Feature\Models;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_campaign_has_many_donations(): void
    {
        $campaign = Campaign::factory()->create();
        Donation::factory(3)->for($campaign)->create();

        $this->assertCount(3, $campaign->donations);
    }

    public function test_is_completed_returns_true_when_deadline_passed(): void
    {
        $campaign = Campaign::factory()->completed()->create();

        $this->assertTrue($campaign->isCompleted());
    }

    public function test_is_completed_returns_true_when_target_reached(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        Donation::factory()->verified()->for($campaign)->create([
            'amount' => 10_000_000,
        ]);

        $this->assertTrue($campaign->isCompleted());
    }

    public function test_is_completed_returns_false_when_target_not_met_and_deadline_not_passed(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        Donation::factory()->verified()->for($campaign)->create([
            'amount' => 2_000_000,
        ]);

        $this->assertFalse($campaign->isCompleted());
    }

    public function test_total_verified_amount_returns_sum_of_verified_donations_only(): void
    {
        $campaign = Campaign::factory()->create();

        Donation::factory()->verified()->for($campaign)->create(['amount' => 100_000]);
        Donation::factory()->verified()->for($campaign)->create(['amount' => 200_000]);
        Donation::factory()->pending()->for($campaign)->create(['amount' => 300_000]);
        Donation::factory()->rejected()->for($campaign)->create(['amount' => 400_000]);

        $this->assertEquals(300_000, $campaign->totalVerifiedAmount());
    }

    public function test_progress_percentage_calculates_correctly(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 10_000_000,
        ]);

        Donation::factory()->verified()->for($campaign)->create(['amount' => 2_500_000]);

        $this->assertEquals(25.0, $campaign->progressPercentage());
    }

    public function test_progress_percentage_capped_at_100(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 5_000_000,
        ]);

        Donation::factory()->verified()->for($campaign)->create(['amount' => 7_000_000]);

        $this->assertEquals(100.0, $campaign->progressPercentage());
    }

    public function test_progress_percentage_returns_100_when_target_is_zero(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 0,
        ]);

        $this->assertEquals(100.0, $campaign->progressPercentage());
    }

    public function test_remaining_days_returns_positive_value(): void
    {
        $campaign = Campaign::factory()->create([
            'deadline' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $this->assertEquals(10, $campaign->remainingDays());
    }

    public function test_remaining_days_returns_zero_when_deadline_passed(): void
    {
        $campaign = Campaign::factory()->completed()->create();

        $this->assertEquals(0, $campaign->remainingDays());
    }
}
