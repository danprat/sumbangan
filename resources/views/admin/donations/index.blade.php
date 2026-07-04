@extends('layouts.admin')

@section('title', 'Donasi')

@section('content')
<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Donasi</h1>
            <p class="mt-1 text-sm text-gray-500">Daftar donasi dengan filter status.</p>
        </div>
    </div>

    <div class="mt-4 flex gap-x-2">
        <a href="{{ route('admin.donations.index') }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ !$currentStatus ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Semua
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'pending']) }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ $currentStatus === 'pending' ? 'bg-amber-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Pending
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'verified']) }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ $currentStatus === 'verified' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Diverifikasi
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'rejected']) }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ $currentStatus === 'rejected' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Ditolak
        </a>
    </div>

    <x-admin.card class="mt-6 overflow-hidden">
        @if($donations->isEmpty())
            <x-admin.empty-state>
                Tidak ada donasi.
            </x-admin.empty-state>
        @else
            <x-admin.table>
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donatur</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($donations as $donation)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $donation->donor_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $donation->campaign?->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($donation->status === 'pending')
                                <x-admin.badge status="pending">Pending</x-admin.badge>
                            @elseif($donation->status === 'verified')
                                <x-admin.badge status="verified">Diverifikasi</x-admin.badge>
                            @else
                                <x-admin.badge status="rejected">Ditolak</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $donation->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <x-admin.button as="a" href="{{ route('admin.donations.show', $donation) }}" variant="secondary">
                                Detail
                            </x-admin.button>
                            @if($donation->status === 'pending')
                                <button onclick="document.getElementById('verify-form-{{ $donation->id }}').submit()"
                                        class="font-medium text-green-600 hover:text-green-500">Verifikasi</button>
                                <form id="verify-form-{{ $donation->id }}" action="{{ route('admin.donations.verify', $donation) }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>

            <div class="border-t border-gray-200 px-6 py-4">
                {{ $donations->links() }}
            </div>
        @endif
    </x-admin.card>
</div>
@endsection
