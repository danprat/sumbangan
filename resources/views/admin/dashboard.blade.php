@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard</h1>
    <p class="mt-1 text-sm text-gray-500">Ringkasan donasi dan campaign.</p>

    <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Donasi Terverifikasi</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                Rp {{ number_format($totalDonasi, 0, ',', '.') }}
            </dd>
        </div>

        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Campaign Aktif</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                {{ $campaignAktif }}
            </dd>
        </div>

        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Donasi Pending</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-amber-600">
                {{ \App\Models\Donation::where('status', 'pending')->count() }}
            </dd>
        </div>
    </dl>

    <div class="mt-8">
        <h2 class="text-lg font-semibold text-gray-900">Donasi Pending Terbaru</h2>

        @if($donasiPending->isEmpty())
            <p class="mt-3 text-sm text-gray-500">Tidak ada donasi yang perlu diverifikasi.</p>
        @else
            <div class="mt-4 overflow-hidden rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donatur</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($donasiPending as $donation)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $donation->donor_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $donation->campaign?->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $donation->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                <a href="{{ route('admin.donations.show', $donation) }}" class="font-medium text-indigo-600 hover:text-indigo-500">Verifikasi</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
