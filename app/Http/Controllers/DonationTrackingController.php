<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DonationTrackingController extends Controller
{
    public function index(): View
    {
        return view('donations.track-index');
    }

    public function search(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string', 'exists:donations,token'],
        ], [
            'token.exists' => 'Kode donasi tidak ditemukan.',
        ]);

        return redirect()->route('donation.track', $request->token);
    }

    public function show(string $token): View
    {
        $donation = Donation::where('token', $token)->firstOrFail();

        $donation->load('campaign');

        return view('donations.track', compact('donation'));
    }
}
