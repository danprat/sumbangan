<?php

namespace Tests\Feature\Public;

use App\Models\BankAccount;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CampaignPageTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_homepage_shows_active_campaigns(): void
    {
        $campaign = Campaign::factory()->create([
            'title' => 'Test Campaign',
            'deadline' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $response = $this->get(route('campaigns.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Campaign');
        $response->assertSee('Donasi');
    }

    public function test_homepage_uses_public_disk_image_url_for_campaigns(): void
    {
        config(['app.url' => 'http://localhost/sumbanngan/public']);
        config(['filesystems.disks.public.url' => 'http://localhost/sumbanngan/public/storage']);

        Campaign::factory()->create([
            'title' => 'Campaign With Image',
            'image_path' => 'campaigns/example.jpg',
            'deadline' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('http://localhost/sumbanngan/public/storage/campaigns/example.jpg', false);
        $response->assertDontSee('src="/storage/campaigns/example.jpg"', false);
    }

    public function test_homepage_shows_completed_campaign_with_detail_link(): void
    {
        Campaign::factory()->completed()->create(['title' => 'Completed Campaign']);

        $response = $this->get(route('campaigns.index'));

        $response->assertStatus(200);
        $response->assertSee('Completed Campaign');
        $response->assertSee('Donasi');
    }

    public function test_campaign_detail_page_shows_info(): void
    {
        $campaign = Campaign::factory()->create([
            'title' => 'Detail Campaign',
            'description' => 'Deskripsi lengkap',
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(20)->format('Y-m-d'),
        ]);

        $response = $this->get(route('campaigns.show', $campaign->slug));

        $response->assertStatus(200);
        $response->assertSee('Detail Campaign');
        $response->assertSee('Deskripsi lengkap');
    }

    public function test_campaign_detail_shows_verified_donors(): void
    {
        $campaign = Campaign::factory()->create();
        Donation::factory()->verified()->for($campaign)->create([
            'donor_name' => 'Budi Santoso',
            'amount' => 100_000,
        ]);

        $response = $this->get(route('campaigns.show', $campaign->slug));

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('100.000');
    }

    public function test_campaign_detail_shows_bank_accounts(): void
    {
        $campaign = Campaign::factory()->create();
        $bankAccount = BankAccount::factory()->create([
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
        ]);

        $response = $this->get(route('campaigns.show', $campaign->slug));

        $response->assertStatus(200);
        $response->assertSee('BCA');
        $response->assertSee('1234567890');
    }

    public function test_completed_campaign_is_accessible_and_shows_final_results(): void
    {
        $campaign = Campaign::factory()->completed()->create([
            'title' => 'Finished Campaign',
            'target_amount' => 10_000_000,
        ]);

        Donation::factory()->verified()->for($campaign)->create(['amount' => 5_000_000]);

        $response = $this->get(route('campaigns.show', $campaign->slug));

        $response->assertStatus(200);
        $response->assertSee('Campaign ini telah berakhir');
    }

    public function test_campaign_shows_completed_banner_when_target_reached(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 1_000_000,
            'deadline' => now()->addDays(10)->format('Y-m-d'),
        ]);
        Donation::factory()->verified()->for($campaign)->create(['amount' => 1_000_000]);

        $response = $this->get(route('campaigns.show', $campaign->slug));

        $response->assertStatus(200);
        $response->assertSee('Campaign ini telah berakhir');
    }

    public function test_invalid_slug_returns_404(): void
    {
        $response = $this->get('/campaign/non-existent-slug');

        $response->assertStatus(404);
    }

    public function test_campaign_without_donations_shows_zero_progress(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $response = $this->get(route('campaigns.show', $campaign->slug));

        $response->assertStatus(200);
        $response->assertSee('Belum ada donasi');
    }
}
