<?php

namespace Tests\Feature\Admin;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DonationVerificationTest extends TestCase
{
    use LazilyRefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_view_donations_list(): void
    {
        Donation::factory(3)->pending()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.donations.index'));

        $response->assertStatus(200);
        $response->assertSee('Donasi');
    }

    public function test_donations_list_filtered_by_status(): void
    {
        Donation::factory(2)->pending()->create();
        Donation::factory(3)->verified()->create();
        Donation::factory(1)->rejected()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.donations.index', ['status' => 'pending']));

        $response->assertStatus(200);
    }

    public function test_admin_can_verify_pending_donation(): void
    {
        $donation = Donation::factory()->pending()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.donations.verify', $donation));

        $response->assertRedirect();
        $this->assertDatabaseHas('donations', [
            'id' => $donation->id,
            'status' => 'verified',
        ]);
        $this->assertNotNull($donation->fresh()->verified_at);
    }

    public function test_verified_donation_triggers_ae1_progress_increase(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        Donation::factory()->verified()->for($campaign)->create(['amount' => 2_000_000]);

        $donation = Donation::factory()->pending()->for($campaign)->create(['amount' => 500_000]);

        $this->actingAs($this->admin)
            ->post(route('admin.donations.verify', $donation));

        $this->assertEquals(2_500_000, $campaign->fresh()->totalVerifiedAmount());
    }

    public function test_admin_can_reject_donation_with_notes(): void
    {
        $donation = Donation::factory()->pending()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.donations.reject', $donation), [
                'admin_notes' => 'Bukti transfer tidak jelas.',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('donations', [
            'id' => $donation->id,
            'status' => 'rejected',
            'admin_notes' => 'Bukti transfer tidak jelas.',
        ]);
    }

    public function test_rejected_donation_does_not_affect_progress_ae2(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        Donation::factory()->verified()->for($campaign)->create(['amount' => 2_000_000]);

        $donation = Donation::factory()->pending()->for($campaign)->create(['amount' => 500_000]);

        $this->actingAs($this->admin)
            ->post(route('admin.donations.reject', $donation), [
                'admin_notes' => 'Tidak valid.',
            ]);

        $this->assertEquals(2_000_000, $campaign->fresh()->totalVerifiedAmount());
    }

    public function test_campaign_completes_when_target_reached_ae3(): void
    {
        $campaign = Campaign::factory()->create([
            'target_amount' => 5_000_000,
            'deadline' => now()->addDays(10)->format('Y-m-d'),
        ]);

        Donation::factory()->verified()->for($campaign)->create(['amount' => 4_500_000]);

        $donation = Donation::factory()->pending()->for($campaign)->create(['amount' => 500_000]);

        $this->actingAs($this->admin)
            ->post(route('admin.donations.verify', $donation));

        $this->assertTrue($campaign->fresh()->isCompleted());
    }

    public function test_cannot_verify_already_verified_donation(): void
    {
        $donation = Donation::factory()->verified()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.donations.verify', $donation));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals('verified', $donation->fresh()->status);
    }

    public function test_cannot_reject_already_rejected_donation(): void
    {
        $donation = Donation::factory()->rejected()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.donations.reject', $donation), [
                'admin_notes' => 'Alasan baru.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_reject_requires_admin_notes(): void
    {
        $donation = Donation::factory()->pending()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.donations.reject', $donation), [
                'admin_notes' => '',
            ]);

        $response->assertSessionHasErrors('admin_notes');
    }

    public function test_guest_cannot_access_donation_routes(): void
    {
        $response = $this->get(route('admin.donations.index'));
        $response->assertRedirect('/admin/login');
    }
}
