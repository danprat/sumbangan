@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        @if($campaign->image_path)
            <img src="{{ Storage::disk('public')->url($campaign->image_path) }}"
                 alt="{{ $campaign->title }}"
                 class="w-full rounded-lg object-cover max-h-96">
        @endif

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-gray-900">{{ $campaign->title }}</h1>

        @if($campaign->description)
            <div class="mt-4 text-gray-600 leading-relaxed whitespace-pre-line">
                {{ $campaign->description }}
            </div>
        @endif

        <!-- Progress -->
        <div class="mt-6 rounded-lg bg-white p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Terkumpul</p>
                    <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($campaign->totalVerifiedAmount(), 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Target</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mt-4 w-full rounded-full bg-gray-200 h-3">
                <div class="h-3 rounded-full {{ $campaign->progressPercentage() >= 100 ? 'bg-green-500' : 'bg-indigo-600' }}"
                     style="width: {{ $campaign->progressPercentage() }}%"></div>
            </div>

            <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                <span>{{ $campaign->progressPercentage() }}% tercapai</span>
                @if($campaign->isCompleted())
                    <span class="text-gray-400">Campaign selesai</span>
                @else
                    <span>{{ $campaign->remainingDays() }} hari lagi</span>
                @endif
            </div>
        </div>

        @if($campaign->isCompleted())
            <div class="mt-6 rounded-lg bg-gray-100 p-4 text-center">
                <p class="text-gray-600 font-medium">Campaign ini telah berakhir.</p>
                <p class="text-sm text-gray-500 mt-1">Terima kasih kepada seluruh donatur yang telah berpartisipasi.</p>
            </div>
        @endif

        <!-- Verified Donors -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900">Donatur ({{ $verifiedDonations->count() }})</h2>

            @if($verifiedDonations->isEmpty())
                <p class="mt-3 text-gray-500">Belum ada donasi terverifikasi. Jadilah yang pertama!</p>
            @else
                <div class="mt-4 overflow-hidden rounded-lg bg-white shadow">
                    <ul class="divide-y divide-gray-200">
                        @foreach($verifiedDonations as $donation)
                            <li class="flex items-center justify-between px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $donation->created_at->format('d M Y') }}</p>
                                </div>
                                <p class="text-sm font-semibold text-indigo-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Bank Accounts -->
        @if($bankAccounts->isNotEmpty())
            <div class="mt-6 rounded-lg bg-white p-6 shadow">
                <h3 class="text-lg font-semibold text-gray-900">Transfer ke Rekening</h3>
                <p class="mt-1 text-sm text-gray-500">Silakan transfer donasi Anda ke salah satu rekening berikut:</p>

                <div class="mt-4 space-y-3">
                    @foreach($bankAccounts as $account)
                        <div class="rounded-md border border-gray-200 p-3">
                            <p class="text-sm font-semibold text-gray-900">{{ $account->bank_name }}</p>
                            <p class="text-sm text-gray-600">{{ $account->account_number }}</p>
                            <p class="text-xs text-gray-500">a.n. {{ $account->account_name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
