<?php

namespace Tests\Feature\Models;

use App\Models\Donation;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DonationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_donation_belongs_to_campaign(): void
    {
        $donation = Donation::factory()->create();

        $this->assertNotNull($donation->campaign);
        $this->assertNotNull($donation->campaign_id);
    }

    public function test_donation_auto_generates_token_on_creation(): void
    {
        $donation = Donation::factory()->create(['token' => null]);

        $this->assertNotNull($donation->token);
        $this->assertNotEmpty($donation->token);
    }

    public function test_donation_has_unique_token(): void
    {
        $donation1 = Donation::factory()->create();
        $donation2 = Donation::factory()->create();

        $this->assertNotEquals($donation1->token, $donation2->token);
    }

    public function test_donation_default_status_is_pending(): void
    {
        $donation = Donation::factory()->create();

        $this->assertEquals('pending', $donation->status);
    }

    public function test_donation_verified_state_sets_status_and_verified_at(): void
    {
        $donation = Donation::factory()->verified()->create();

        $this->assertEquals('verified', $donation->status);
        $this->assertNotNull($donation->verified_at);
    }

    public function test_donation_rejected_state_sets_status_and_admin_notes(): void
    {
        $donation = Donation::factory()->rejected()->create();

        $this->assertEquals('rejected', $donation->status);
        $this->assertNotNull($donation->admin_notes);
    }

    public function test_donation_amount_is_cast_to_integer(): void
    {
        $donation = Donation::factory()->create(['amount' => 100_000]);

        $this->assertIsInt($donation->amount);
        $this->assertEquals(100_000, $donation->amount);
    }

    public function test_verified_at_is_cast_to_datetime(): void
    {
        $donation = Donation::factory()->verified()->create();

        $this->assertInstanceOf(\Carbon\Carbon::class, $donation->verified_at);
    }
}
