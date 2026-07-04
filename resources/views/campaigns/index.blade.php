@extends('layouts.app')

@section('title', 'Sumbangan - Wujudkan Kebaikan Hari Ini')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white overflow-hidden rounded-3xl shadow-sm mb-12">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 px-6 pt-10 sm:px-8">
            <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Satu Langkah Kecil,</span>
                        <span class="block text-indigo-600 xl:inline">Perubahan Besar</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Mari bersama-sama mewujudkan harapan mereka yang membutuhkan. Setiap donasi Anda memberikan dampak nyata bagi kehidupan sesama.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="#campaigns" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition">
                                Mulai Donasi
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-indigo-50 flex items-center justify-center rounded-l-[100px] hidden lg:flex">
        <svg class="w-64 h-64 text-indigo-200" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
    </div>
</div>

<!-- Campaigns Section -->
<div id="campaigns">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Program Mendesak</h2>
            <p class="mt-2 text-gray-500">Pilih campaign yang ingin Anda dukung dan salurkan kebaikan Anda.</p>
        </div>
    </div>

    @if($campaigns->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
            <div class="mx-auto h-24 w-24 text-gray-300 flex items-center justify-center">
                 <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <p class="mt-4 text-gray-500 font-medium">Belum ada campaign yang tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($campaigns as $campaign)
                <x-campaign-card :campaign="$campaign" />
            @endforeach
        </div>
    @endif
</div>
@endsection
