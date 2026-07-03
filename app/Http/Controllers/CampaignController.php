<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Campaign;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(): View
    {
        $campaigns = Campaign::latest()->get();

        return view('campaigns.index', compact('campaigns'));
    }

    public function show(string $slug): View
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        $bankAccounts = BankAccount::all();
        $verifiedDonations = $campaign->donations()
            ->where('status', 'verified')
            ->latest()
            ->get();

        return view('campaigns.show', compact('campaign', 'bankAccounts', 'verifiedDonations'));
    }
}
