<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function store(StoreDonationRequest $request, string $slug): RedirectResponse
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        if ($campaign->isCompleted()) {
            return back()->with('error', 'Maaf, campaign ini sudah berakhir dan tidak menerima donasi baru.');
        }

        $data = $request->validated();

        $data['campaign_id'] = $campaign->id;
        $data['proof_image_path'] = $request->file('proof_image')->store('donations', 'public');
        $data['status'] = 'pending';

        unset($data['proof_image']);

        $donation = Donation::create($data);

        return redirect()->route('donations.confirmation', $donation->token);
    }

    public function confirmation(string $token): View
    {
        $donation = Donation::where('token', $token)->firstOrFail();

        return view('donations.confirmation', compact('donation'));
    }
}
