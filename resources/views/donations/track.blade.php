@extends('layouts.app')

@section('title', 'Lacak Donasi')

@section('content')
@php
    $statusLabel = match ($donation->status) {
        'verified' => 'Diverifikasi',
        'rejected' => 'Ditolak',
        default => 'Menunggu Verifikasi',
    };

    $statusClasses = match ($donation->status) {
        'verified' => 'bg-[#e6f4ea] text-[#137333] border-[#ceead6]',
        'rejected' => 'bg-error-container text-on-error-container border-[#f2b8b5]',
        default => 'bg-[#fff8e1] text-[#8d6e00] border-[#f5df95]',
    };

    $statusIcon = match ($donation->status) {
        'verified' => 'check_circle',
        'rejected' => 'cancel',
        default => 'schedule',
    };
@endphp

<main class="flex-grow flex flex-col items-center justify-center py-xl px-margin-mobile md:px-margin-desktop w-full max-w-max-width mx-auto">
    <div class="text-center mb-lg max-w-2xl mx-auto">
        <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-on-surface mb-xs">Track Your Impact</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">Status verifikasi donasi Anda ditampilkan di sini, lengkap dengan detail kontribusi dan kampanye yang didukung.</p>
    </div>

    <div class="w-full max-w-3xl bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-surface-container-low transition-opacity duration-300 opacity-100" id="resultsSection">
        <div class="flex flex-col gap-sm md:flex-row md:justify-between md:items-start mb-lg border-b border-surface-container pb-sm">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface mb-base">Donation Status</h2>
                <p class="font-body-md text-body-md text-on-surface-variant font-mono break-all">Token: {{ $donation->token }}</p>
            </div>
            <div class="{{ $statusClasses }} font-label-sm text-label-sm px-3 py-1 rounded flex items-center gap-xs border w-fit">
                <span class="material-symbols-outlined text-[16px]">{{ $statusIcon }}</span>
                {{ $statusLabel }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-md mb-lg">
            <div class="bg-surface-container-low p-sm rounded-lg">
                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">Nama Donatur</span>
                <span class="block font-body-lg text-body-lg text-on-surface font-semibold">{{ $donation->donor_name }}</span>
            </div>
            <div class="bg-surface-container-low p-sm rounded-lg">
                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">Nominal Donasi</span>
                <span class="block font-body-lg text-body-lg text-on-surface font-semibold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
            </div>
            <div class="bg-surface-container-low p-sm rounded-lg md:col-span-2 flex flex-col md:flex-row gap-sm items-center">
                @if($donation->campaign->image_path)
                    <img
                        alt="{{ $donation->campaign->title }}"
                        class="w-24 h-24 rounded-lg object-cover flex-shrink-0 bg-surface-container-high"
                        src="{{ Storage::disk('public')->url($donation->campaign->image_path) }}"
                    />
                @else
                    <div class="w-24 h-24 rounded-lg flex items-center justify-center flex-shrink-0 bg-surface-container-high text-primary">
                        <span class="material-symbols-outlined text-4xl">volunteer_activism</span>
                    </div>
                @endif
                <div>
                    <span class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">Kampanye Didukung</span>
                    <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="block font-body-lg text-body-lg text-on-surface font-semibold mb-xs hover:text-primary transition-colors">
                        {{ $donation->campaign->title }}
                    </a>
                    <p class="font-body-md text-body-md text-on-surface-variant">Lacak kampanye ini kembali kapan saja melalui halaman detail kampanye.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-surface-container pt-md">
            <h3 class="font-label-md text-label-md text-on-surface-variant mb-sm">Timeline Donasi</h3>
            <div class="relative border-l-2 border-surface-container-high ml-sm space-y-md pb-xs">
                @if($donation->status === 'rejected' && $donation->admin_notes)
                    <div class="relative pl-sm">
                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-error border-2 border-surface-container-lowest"></span>
                        <p class="font-label-md text-label-md text-on-surface font-semibold">Donasi Ditolak</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $donation->updated_at->format('d M Y • H:i') }}</p>
                        <p class="mt-xs font-body-md text-body-md text-on-surface-variant">{{ $donation->admin_notes }}</p>
                    </div>
                @elseif($donation->status === 'verified' && $donation->verified_at)
                    <div class="relative pl-sm">
                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-secondary border-2 border-surface-container-lowest"></span>
                        <p class="font-label-md text-label-md text-on-surface font-semibold">Donasi Diverifikasi</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $donation->verified_at->format('d M Y • H:i') }}</p>
                    </div>
                @endif

                <div class="relative pl-sm">
                    <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full {{ $donation->status === 'pending' ? 'bg-secondary' : 'bg-outline-variant' }} border-2 border-surface-container-lowest"></span>
                    <p class="font-label-md text-label-md text-on-surface font-semibold">Donasi Diterima</p>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $donation->created_at->format('d M Y • H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-md">
            <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="inline-flex items-center gap-xs text-label-md font-label-md text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Campaign
            </a>
        </div>
    </div>
</main>
@endsection
