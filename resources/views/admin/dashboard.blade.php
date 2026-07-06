@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-max-width mx-auto space-y-lg">
    <!-- Dashboard Header -->
    <div>
        <h2 class="text-display-lg-mobile md:text-display-lg font-display-lg text-on-background">Overview</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant mt-2">Welcome back. Here is the latest impact data.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <!-- Stat Card 1 -->
        <div class="bg-surface-container-lowest p-md rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/20 hover:shadow-[0px_8px_30px_rgba(0,0,0,0.08)] transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-label-md font-label-md text-on-surface-variant">Total Collections</h3>
                <div class="w-10 h-10 rounded-full bg-primary-container/20 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
            </div>
            <p class="text-headline-md font-headline-md text-on-background">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
            <p class="text-label-sm font-label-sm text-secondary mt-2 flex items-center gap-1">
                Verified Donations
            </p>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-surface-container-lowest p-md rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/20 hover:shadow-[0px_8px_30px_rgba(0,0,0,0.08)] transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-label-md font-label-md text-on-surface-variant">Active Campaigns</h3>
                <div class="w-10 h-10 rounded-full bg-secondary-container/30 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined">volunteer_activism</span>
                </div>
            </div>
            <p class="text-headline-md font-headline-md text-on-background">{{ $campaignAktif }}</p>
            <p class="text-label-sm font-label-sm text-on-surface-variant mt-2">Ongoing programs</p>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-surface-container-lowest p-md rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/20 hover:shadow-[0px_8px_30px_rgba(0,0,0,0.08)] transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-label-md font-label-md text-on-surface-variant">Pending Verifications</h3>
                <div class="w-10 h-10 rounded-full bg-[#fff3cd] flex items-center justify-center text-[#856404]">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
            </div>
            <p class="text-headline-md font-headline-md text-on-background">{{ \App\Models\Donation::where('status', 'pending')->count() }}</p>
            <p class="text-label-sm font-label-sm text-on-surface-variant mt-2">Requires attention</p>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-surface-container-lowest p-md rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/20 hover:shadow-[0px_8px_30px_rgba(0,0,0,0.08)] transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-label-md font-label-md text-on-surface-variant">Total Donors</h3>
                <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">group</span>
                </div>
            </div>
            <p class="text-headline-md font-headline-md text-on-background">{{ \App\Models\Donation::where('status', 'verified')->distinct('donor_email')->count('donor_email') }}</p>
            <p class="text-label-sm font-label-sm text-secondary mt-2 flex items-center gap-1">
                Unique verified donors
            </p>
        </div>
    </div>

    <!-- Main Content Area: Bento Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <!-- Pending Donations Table -->
        <div class="lg:col-span-2 bg-surface-container-lowest p-md rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/20">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-headline-md font-headline-md text-on-background">Pending Donations</h3>
                <a href="{{ route('admin.donations.index') }}" class="text-primary text-label-md font-label-md hover:underline">View All</a>
            </div>
            
            @if($donasiPending->isEmpty())
                <div class="text-center py-10">
                    <p class="text-on-surface-variant text-body-md">No pending donations to verify.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-outline-variant/50 text-label-sm font-label-sm text-on-surface-variant">
                                <th class="pb-3 font-semibold">Donor Name</th>
                                <th class="pb-3 font-semibold">Campaign</th>
                                <th class="pb-3 font-semibold">Amount</th>
                                <th class="pb-3 font-semibold">Date</th>
                                <th class="pb-3 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-body-md font-body-md text-on-background">
                            @foreach($donasiPending as $donation)
                                <tr class="border-b border-outline-variant/30 hover:bg-surface-container/30 transition-colors">
                                    <td class="py-4 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-primary font-bold text-label-sm">
                                            {{ substr($donation->donor_name, 0, 2) }}
                                        </div>
                                        {{ $donation->donor_name }}
                                    </td>
                                    <td class="py-4 text-sm text-on-surface-variant max-w-[150px] truncate">
                                        {{ $donation->campaign?->title }}
                                    </td>
                                    <td class="py-4 font-semibold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                                    <td class="py-4 text-on-surface-variant text-label-md">{{ $donation->created_at->format('M d, Y') }}</td>
                                    <td class="py-4 text-right">
                                        <a href="{{ route('admin.donations.show', $donation) }}" class="text-primary text-label-md font-label-md font-semibold hover:text-primary-container transition-colors">Verify</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Quick Actions & Secondary Info -->
        <div class="space-y-gutter">
            <!-- Quick Actions -->
            <div class="bg-surface-container-lowest p-md rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/20">
                <h3 class="text-headline-md font-headline-md text-on-background mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.campaigns.create') }}" class="w-full bg-primary text-on-primary text-label-md font-label-md font-semibold py-3 px-4 rounded-lg flex items-center justify-center gap-2 hover:bg-on-primary-fixed-variant transition-colors shadow-sm">
                        <span class="material-symbols-outlined">add_circle</span>
                        New Campaign
                    </a>
                    <a href="{{ route('admin.bank-accounts.index') }}" class="w-full border-2 border-primary text-primary text-label-md font-label-md font-semibold py-3 px-4 rounded-lg flex items-center justify-center gap-2 hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined">account_balance</span>
                        Manage Bank Accounts
                    </a>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-surface-container p-md rounded-xl border border-outline-variant/20 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-surface-tint opacity-10">
                    <span class="material-symbols-outlined text-[100px]">security</span>
                </div>
                <h3 class="text-label-md font-label-md text-on-surface-variant mb-2 relative z-10">System Status</h3>
                <div class="flex items-center gap-2 mb-1 relative z-10">
                    <div class="w-2 h-2 rounded-full bg-secondary"></div>
                    <span class="text-body-md font-body-md text-on-background font-semibold">All systems operational</span>
                </div>
                <p class="text-label-sm font-label-sm text-on-surface-variant relative z-10">Last updated: Just now</p>
            </div>
        </div>
    </div>
</div>
@endsection
