@extends('layouts.admin')

@section('title', 'Donasi')

@section('content')
<div class="space-y-lg">
    <div>
        <h1 class="text-display-lg-mobile font-display-lg text-on-background">Donasi</h1>
        <p class="mt-2 text-body-md text-on-surface-variant">Pantau status donasi dan proses verifikasi dari satu daftar yang konsisten.</p>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.donations.index') }}" class="rounded-full px-4 py-2 text-label-md font-label-md {{ !$currentStatus ? 'bg-primary text-on-primary' : 'border border-outline-variant bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container' }}">Semua</a>
        <a href="{{ route('admin.donations.index', ['status' => 'pending']) }}" class="rounded-full px-4 py-2 text-label-md font-label-md {{ $currentStatus === 'pending' ? 'bg-[#fff3cd] text-[#856404]' : 'border border-outline-variant bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container' }}">Pending</a>
        <a href="{{ route('admin.donations.index', ['status' => 'verified']) }}" class="rounded-full px-4 py-2 text-label-md font-label-md {{ $currentStatus === 'verified' ? 'bg-secondary-container text-on-secondary-container' : 'border border-outline-variant bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container' }}">Diverifikasi</a>
        <a href="{{ route('admin.donations.index', ['status' => 'rejected']) }}" class="rounded-full px-4 py-2 text-label-md font-label-md {{ $currentStatus === 'rejected' ? 'bg-error-container text-on-error-container' : 'border border-outline-variant bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container' }}">Ditolak</a>
    </div>

    <x-admin.card class="overflow-hidden">
        @if($donations->isEmpty())
            <x-admin.empty-state>
                Tidak ada donasi.
            </x-admin.empty-state>
        @else
            <x-admin.table>
                <thead class="bg-surface-container-low text-label-sm font-label-sm uppercase text-on-surface-variant">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Donatur</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Campaign</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nominal</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                        <th scope="col" class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/40">
                    @foreach($donations as $donation)
                    <tr class="hover:bg-surface-container/30 transition-colors">
                        <td class="px-6 py-5 font-semibold text-on-background">{{ $donation->donor_name }}</td>
                        <td class="px-6 py-5 text-on-surface-variant">{{ $donation->campaign?->title }}</td>
                        <td class="px-6 py-5 text-on-background">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-5">
                            <x-admin.badge :status="$donation->status">
                                {{ ucfirst($donation->status) }}
                            </x-admin.badge>
                        </td>
                        <td class="px-6 py-5 text-on-surface-variant">{{ $donation->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-3">
                                <x-admin.button as="a" href="{{ route('admin.donations.show', $donation) }}" variant="secondary">Detail</x-admin.button>
                                @if($donation->status === 'pending')
                                    <button onclick="document.getElementById('verify-form-{{ $donation->id }}').submit()" class="text-label-md font-label-md text-secondary transition-colors hover:opacity-80">Verifikasi</button>
                                    <form id="verify-form-{{ $donation->id }}" action="{{ route('admin.donations.verify', $donation) }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>

            <div class="border-t border-outline-variant/40 px-6 py-4">
                {{ $donations->links() }}
            </div>
        @endif
    </x-admin.card>
</div>
@endsection
