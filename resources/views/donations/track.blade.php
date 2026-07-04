@extends('layouts.app')

@section('title', 'Lacak Donasi')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="rounded-lg bg-white p-8 shadow">
        <h1 class="text-xl font-bold text-gray-900">Status Donasi</h1>

        <!-- Status Badge -->
        <div class="mt-4">
            @if($donation->status === 'verified')
                <span class="inline-flex items-center rounded-md bg-green-50 px-3 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                    Diverifikasi
                </span>
            @elseif($donation->status === 'rejected')
                <span class="inline-flex items-center rounded-md bg-red-50 px-3 py-1 text-sm font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                    Ditolak
                </span>
            @else
                <span class="inline-flex items-center rounded-md bg-yellow-50 px-3 py-1 text-sm font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">
                    Menunggu Verifikasi
                </span>
            @endif
        </div>

        <!-- Donation Details -->
        <dl class="mt-6 divide-y divide-gray-100">
            <div class="px-0 py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Campaign</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="text-indigo-600 hover:text-indigo-500">
                        {{ $donation->campaign->title }}
                    </a>
                </dd>
            </div>

            <div class="px-0 py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Nama Donatur</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $donation->donor_name }}</dd>
            </div>

            <div class="px-0 py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Nominal</dt>
                <dd class="mt-1 text-sm font-semibold text-indigo-600 sm:col-span-2 sm:mt-0">Rp {{ number_format($donation->amount, 0, ',', '.') }}</dd>
            </div>

            <div class="px-0 py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-gray-500">Tanggal Donasi</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $donation->created_at->format('d M Y H:i') }}</dd>
            </div>

            @if($donation->status === 'verified' && $donation->verified_at)
                <div class="px-0 py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Diverifikasi Pada</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $donation->verified_at->format('d M Y H:i') }}</dd>
                </div>
            @endif

            @if($donation->status === 'rejected' && $donation->admin_notes)
                <div class="px-0 py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Catatan Admin</dt>
                    <dd class="mt-1 text-sm text-red-600 sm:col-span-2 sm:mt-0">{{ $donation->admin_notes }}</dd>
                </div>
            @endif
        </dl>

        <div class="mt-6">
            <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="text-sm text-gray-500 hover:text-indigo-600">
                &larr; Kembali ke Campaign
            </a>
        </div>
    </div>
</div>
@endsection
