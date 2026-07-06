<?php

namespace Tests\Feature\Public;

use App\Models\Donation;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class DonationTrackingTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_valid_token_shows_pending_status(): void
    {
        $donation = Donation::factory()->pending()->create();

        $response = $this->get(route('donation.track', $donation->token));

        $response->assertOk();
        $response->assertSee('Menunggu Verifikasi');
        $response->assertSee($donation->donor_name);
        $response->assertSee(number_format($donation->amount, 0, ',', '.'));
        $response->assertSee($donation->campaign->title);
    }

    public function test_valid_token_shows_verified_status(): void
    {
        $donation = Donation::factory()->verified()->create();

        $response = $this->get(route('donation.track', $donation->token));

        $response->assertOk();
        $response->assertSee('Diverifikasi');
        $response->assertSee($donation->donor_name);
    }

    public function test_valid_token_shows_rejected_status_with_notes(): void
    {
        $donation = Donation::factory()->rejected()->create();

        $response = $this->get(route('donation.track', $donation->token));

        $response->assertOk();
        $response->assertSee('Ditolak');
        $response->assertSee($donation->admin_notes);
    }

    public function test_invalid_token_returns_404(): void
    {
        $response = $this->get(route('donation.track', 'invalid-uuid-token'));

        $response->assertNotFound();
    }

    public function test_tracking_page_has_link_back_to_campaign(): void
    {
        $donation = Donation::factory()->pending()->create();

        $response = $this->get(route('donation.track', $donation->token));

        $response->assertOk();
        $response->assertSee(route('campaigns.show', $donation->campaign->slug));
    }
}
