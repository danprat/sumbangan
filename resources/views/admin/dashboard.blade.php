@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <header class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Overview performa donasi dan campaign aktif Anda.</p>
        </div>
        <div class="flex gap-3">
            <x-admin.button as="a" href="{{ route('admin.campaigns.create') }}" class="shadow-sm">
                + Buat Campaign
            </x-admin.button>
        </div>
    </header>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <x-admin.card class="relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="p-6">
                <dt class="flex items-center gap-2 text-sm font-medium text-gray-500">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Total Donasi Terverifikasi
                </dt>
                <dd class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                    Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                </dd>
            </div>
            <div class="absolute inset-x-0 bottom-0 h-1 bg-indigo-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform"></div>
        </x-admin.card>

        <x-admin.card class="relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="p-6">
                <dt class="flex items-center gap-2 text-sm font-medium text-gray-500">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                    Campaign Aktif
                </dt>
                <dd class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-gray-900">{{ $campaignAktif }}</span>
                    <span class="text-sm font-medium text-gray-500">campaign</span>
                </dd>
            </div>
            <div class="absolute inset-x-0 bottom-0 h-1 bg-emerald-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform"></div>
        </x-admin.card>

        <x-admin.card class="relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="p-6">
                <dt class="flex items-center gap-2 text-sm font-medium text-gray-500">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Donasi Pending
                </dt>
                <dd class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-amber-600">{{ \App\Models\Donation::where('status', 'pending')->count() }}</span>
                    <span class="text-sm font-medium text-gray-500">menunggu verifikasi</span>
                </dd>
            </div>
            <div class="absolute inset-x-0 bottom-0 h-1 bg-amber-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform"></div>
        </x-admin.card>
    </div>

    <section class="bg-white ring-1 ring-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Perlu Verifikasi Segera</h2>
            <a href="{{ route('admin.donations.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lihat semua donasi &rarr;</a>
        </div>

        @if($donasiPending->isEmpty())
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Semua Bersih</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ada donasi yang menunggu verifikasi saat ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donatur</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-6"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($donasiPending as $donation)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 shrink-0 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-medium text-xs">
                                        {{ substr($donation->donor_name, 0, 2) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900 text-sm">{{ $donation->donor_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <span class="truncate max-w-[200px] inline-block" title="{{ $donation->campaign?->title }}">
                                    {{ $donation->campaign?->title }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{ $donation->created_at->diffForHumans() }}
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                <x-admin.button as="a" href="{{ route('admin.donations.show', $donation) }}" variant="secondary" class="!py-1.5 !text-xs">
                                    Verifikasi
                                </x-admin.button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
@endsection
