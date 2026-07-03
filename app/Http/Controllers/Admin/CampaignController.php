<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function index(): View
    {
        $campaigns = Campaign::withSum(['donations as total_verified' => function ($q) {
            $q->where('status', 'verified');
        }], 'amount')
            ->latest()
            ->get();

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create(): View
    {
        return view('admin.campaigns.create');
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('campaigns', 'public');
        }

        unset($data['image']);

        $data['slug'] = $this->generateUniqueSlug($data['title']);

        Campaign::create($data);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil dibuat.');
    }

    public function edit(Campaign $campaign): View
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($campaign->image_path) {
                Storage::disk('public')->delete($campaign->image_path);
            }
            $data['image_path'] = $request->file('image')->store('campaigns', 'public');
        }

        unset($data['image']);

        if ($data['title'] !== $campaign->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $campaign->id);
        }

        $campaign->update($data);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil diperbarui.');
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        if ($campaign->image_path) {
            Storage::disk('public')->delete($campaign->image_path);
        }

        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil dihapus.');
    }

    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        $query = Campaign::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $original . '-' . $counter;
            $counter++;

            $query = Campaign::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}
