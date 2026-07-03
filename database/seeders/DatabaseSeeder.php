<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@sumbangan.com',
        ]);

        // Bank accounts for development
        BankAccount::factory(2)->create();

        // Active campaigns with some verified donations
        $activeCampaign = Campaign::factory()->create([
            'title' => 'Bantu Korban Banjir',
            'target_amount' => 10_000_000,
            'deadline' => now()->addDays(30)->format('Y-m-d'),
        ]);

        Donation::factory(5)->verified()->for($activeCampaign)->create([
            'amount' => 2_000_000,
        ]);

        Donation::factory(3)->pending()->for($activeCampaign)->create();

        $anotherCampaign = Campaign::factory()->create([
            'title' => 'Renovasi Masjid Al-Hikmah',
            'target_amount' => 50_000_000,
            'deadline' => now()->addDays(45)->format('Y-m-d'),
        ]);

        Donation::factory(3)->verified()->for($anotherCampaign)->create();

        // A completed campaign (deadline passed)
        $completedCampaign = Campaign::factory()->completed()->create([
            'title' => 'Beasiswa Anak Yatim 2025',
            'target_amount' => 5_000_000,
        ]);

        Donation::factory(4)->verified()->for($completedCampaign)->create([
            'amount' => 1_250_000,
        ]);

        // Some rejected donations
        Donation::factory(2)->rejected()->for($activeCampaign)->create();
    }
}
