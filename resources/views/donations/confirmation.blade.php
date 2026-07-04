@extends('layouts.app')

@section('title', 'Terima Kasih')

@section('content')
<div class="mx-auto max-w-lg text-center">
    <div class="rounded-lg bg-white p-8 shadow">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="mt-4 text-2xl font-bold text-gray-900">Terima Kasih!</h1>
        <p class="mt-2 text-gray-600">Donasi Anda sedang menunggu verifikasi dari admin.</p>

        <div class="mt-6 rounded-md bg-gray-50 p-4">
            <p class="text-sm text-gray-500">Token pelacakan donasi Anda:</p>
            <p class="mt-1 text-lg font-mono font-bold text-indigo-600 break-all">{{ $donation->token }}</p>

            <p class="mt-3 text-sm text-gray-500">Simpan link berikut untuk melacak status donasi:</p>
            <a href="{{ route('donation.track', $donation->token) }}" class="mt-1 block text-sm text-indigo-600 font-mono break-all hover:text-indigo-500">
                {{ route('donation.track', $donation->token) }}
            </a>
        </div>

        <div class="mt-6">
            <a href="{{ route('donation.track', $donation->token) }}"
               class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                Lacak Status Donasi
            </a>
        </div>

        <p class="mt-4">
            <a href="{{ route('campaigns.show', $donation->campaign->slug) }}" class="text-sm text-gray-500 hover:text-indigo-600">
                &larr; Kembali ke Campaign
            </a>
        </p>
    </div>
</div>
@endsection
