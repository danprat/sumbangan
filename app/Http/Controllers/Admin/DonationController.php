<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Donation::with('campaign')->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'verified', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $donations = $query->paginate(20)->withQueryString();
        $currentStatus = $request->status;

        return view('admin.donations.index', compact('donations', 'currentStatus'));
    }

    public function show(Donation $donation): View
    {
        $donation->load('campaign');

        return view('admin.donations.show', compact('donation'));
    }

    public function verify(Donation $donation): RedirectResponse
    {
        if ($donation->status !== 'pending') {
            return back()->with('error', 'Donasi ini sudah diproses sebelumnya.');
        }

        $donation->update([
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.donations.index', ['status' => 'verified'])
            ->with('success', 'Donasi berhasil diverifikasi.');
    }

    public function reject(Request $request, Donation $donation): RedirectResponse
    {
        if ($donation->status !== 'pending') {
            return back()->with('error', 'Donasi ini sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'admin_notes' => ['required', 'string', 'max:1000'],
        ]);

        $donation->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()->route('admin.donations.index', ['status' => 'rejected'])
            ->with('success', 'Donasi telah ditolak.');
    }
}
