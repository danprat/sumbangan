<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalDonasi = (int) Donation::where('status', 'verified')->sum('amount');

        $campaignAktif = Campaign::where('deadline', '>=', now()->startOfDay()->format('Y-m-d'))
            ->get()
            ->filter(fn (Campaign $c) => ! $c->isCompleted())
            ->count();

        $donasiPending = Donation::where('status', 'pending')
            ->with('campaign')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('totalDonasi', 'campaignAktif', 'donasiPending'));
    }
}
