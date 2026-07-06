<?php

namespace Tests\Feature\Public;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class DonationSubmissionTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_donor_can_submit_valid_donation(): void
    {
        Storage::fake('public');

        $campaign = Campaign::factory()->create([
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $image = UploadedFile::fake()->image('proof.jpg', 800, 600);

        $response = $this->post(route('campaigns.donate', $campaign->slug), [
            'donor_name' => 'Budi',
            'donor_email' => 'budi@example.com',
            'amount' => 100_000,
            'proof_image' => $image,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('donations', [
            'donor_name' => 'Budi',
            'status' => 'pending',
            'amount' => 100_000,
        ]);

        $donation = Donation::first();
        $this->assertNotNull($donation->token);
        Storage::disk('public')->assertExists($donation->proof_image_path);
    }

    public function test_donation_token_is_generated(): void
    {
        Storage::fake('public');

        $campaign = Campaign::factory()->create([
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $image = UploadedFile::fake()->image('proof.jpg');

        $this->post(route('campaigns.donate', $campaign->slug), [
            'donor_name' => 'Ani',
            'amount' => 50_000,
            'proof_image' => $image,
        ]);

        $donation = Donation::first();
        $this->assertNotNull($donation->token);
        $this->assertNotEmpty($donation->token);
    }

    public function test_cannot_submit_donation_to_completed_campaign(): void
    {
        Storage::fake('public');

        $campaign = Campaign::factory()->completed()->create();

        $image = UploadedFile::fake()->image('proof.jpg');

        $response = $this->post(route('campaigns.donate', $campaign->slug), [
            'donor_name' => 'Test',
            'amount' => 100_000,
            'proof_image' => $image,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_validation_fails_when_donor_name_empty(): void
    {
        $campaign = Campaign::factory()->create([
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $response = $this->post(route('campaigns.donate', $campaign->slug), [
            'donor_name' => '',
            'amount' => 100_000,
        ]);

        $response->assertSessionHasErrors('donor_name');
    }

    public function test_validation_fails_when_amount_below_minimum(): void
    {
        $campaign = Campaign::factory()->create([
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $response = $this->post(route('campaigns.donate', $campaign->slug), [
            'donor_name' => 'Test',
            'amount' => 500,
        ]);

        $response->assertSessionHasErrors('amount');
    }

    public function test_validation_fails_when_proof_image_not_provided(): void
    {
        $campaign = Campaign::factory()->create([
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $response = $this->post(route('campaigns.donate', $campaign->slug), [
            'donor_name' => 'Test',
            'amount' => 100_000,
        ]);

        $response->assertSessionHasErrors('proof_image');
    }

    public function test_confirmation_page_displays_token_url(): void
    {
        Storage::fake('public');

        $campaign = Campaign::factory()->create([
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $image = UploadedFile::fake()->image('proof.jpg');

        $response = $this->post(route('campaigns.donate', $campaign->slug), [
            'donor_name' => 'Test',
            'amount' => 100_000,
            'proof_image' => $image,
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString('/donations/', $response->headers->get('Location'));
    }
}
