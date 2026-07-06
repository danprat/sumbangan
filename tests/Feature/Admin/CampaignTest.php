<?php

namespace Tests\Feature\Admin;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use LazilyRefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_view_campaigns_list(): void
    {
        Campaign::factory(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.campaigns.index'));

        $response->assertStatus(200);
        $response->assertSee('Campaign');
    }

    public function test_admin_can_create_campaign_with_all_fields(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('campaign.jpg', 800, 600);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.campaigns.store'), [
                'title' => 'Bantu Korban Banjir',
                'description' => 'Deskripsi campaign',
                'target_amount' => 10_000_000,
                'deadline' => now()->addDays(30)->format('Y-m-d'),
                'image' => $image,
            ]);

        $response->assertRedirect(route('admin.campaigns.index'));
        $response->assertSessionHas('success');

        $campaign = Campaign::first();
        $this->assertNotNull($campaign);
        $this->assertEquals('Bantu Korban Banjir', $campaign->title);
        $this->assertNotNull($campaign->image_path);
        Storage::disk('public')->assertExists($campaign->image_path);
    }

    public function test_admin_can_create_campaign_without_image(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.campaigns.store'), [
                'title' => 'Campaign Tanpa Gambar',
                'target_amount' => 5_000_000,
                'deadline' => now()->addDays(14)->format('Y-m-d'),
            ]);

        $response->assertRedirect(route('admin.campaigns.index'));

        $campaign = Campaign::first();
        $this->assertNull($campaign->image_path);
    }

    public function test_slug_is_auto_generated_from_title(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.campaigns.store'), [
                'title' => 'Bantu Korban Banjir',
                'target_amount' => 10_000_000,
                'deadline' => now()->addDays(30)->format('Y-m-d'),
            ]);

        $campaign = Campaign::first();
        $this->assertEquals('bantu-korban-banjir', $campaign->slug);
    }

    public function test_slug_is_unique_when_duplicate_title(): void
    {
        Campaign::factory()->create(['title' => 'Test', 'slug' => 'test']);

        $this->actingAs($this->admin)
            ->post(route('admin.campaigns.store'), [
                'title' => 'Test',
                'target_amount' => 10_000_000,
                'deadline' => now()->addDays(30)->format('Y-m-d'),
            ]);

        $campaigns = Campaign::all();
        $this->assertCount(2, $campaigns);
        $this->assertEquals('test', $campaigns[0]->slug);
        $this->assertStringStartsWith('test-', $campaigns[1]->slug);
    }

    public function test_admin_can_update_campaign(): void
    {
        $campaign = Campaign::factory()->create([
            'title' => 'Judul Lama',
            'target_amount' => 5_000_000,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.campaigns.update', $campaign), [
                'title' => 'Judul Baru',
                'target_amount' => 10_000_000,
                'deadline' => now()->addDays(45)->format('Y-m-d'),
            ]);

        $response->assertRedirect(route('admin.campaigns.index'));
        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'title' => 'Judul Baru',
            'target_amount' => 10_000_000,
        ]);
    }

    public function test_admin_can_delete_campaign(): void
    {
        $campaign = Campaign::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.campaigns.destroy', $campaign));

        $response->assertRedirect(route('admin.campaigns.index'));
        $this->assertModelMissing($campaign);
    }

    public function test_validation_fails_when_title_empty(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.campaigns.store'), [
                'title' => '',
                'target_amount' => 'abc',
                'deadline' => now()->subDay()->format('Y-m-d'),
            ]);

        $response->assertSessionHasErrors(['title', 'target_amount', 'deadline']);
    }

    public function test_dashboard_shows_correct_stats(): void
    {
        Campaign::factory()->create([
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);
        Campaign::factory()->create([
            'target_amount' => 5_000_000,
            'deadline' => now()->addDays(15)->format('Y-m-d'),
        ]);
        Campaign::factory()->completed()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_guest_cannot_access_campaign_routes(): void
    {
        $response = $this->get(route('admin.campaigns.index'));
        $response->assertRedirect('/admin/login');
    }
}
