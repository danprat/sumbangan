@extends('layouts.admin')

@section('title', 'Detail Donasi')

@section('content')
<div class="max-w-2xl">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Detail Donasi</h1>
        <x-admin.button as="a" href="{{ route('admin.donations.index') }}" variant="secondary">&larr; Kembali</x-admin.button>
    </div>

    <x-admin.card class="mt-6 overflow-hidden">
        <div class="px-6 py-5">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Donatur</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $donation->donor_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email / Telepon</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $donation->donor_email ?? '-' }} / {{ $donation->donor_phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Campaign</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $donation->campaign?->title }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nominal</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm">
                        @if($donation->status === 'pending')
                            <x-admin.badge status="pending">Pending</x-admin.badge>
                        @elseif($donation->status === 'verified')
                            <x-admin.badge status="verified">Diverifikasi</x-admin.badge>
                        @else
                            <x-admin.badge status="rejected">Ditolak</x-admin.badge>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal Donasi</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $donation->created_at->format('d M Y H:i') }}</dd>
                </div>
                @if($donation->status === 'verified')
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Verifikasi</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $donation->verified_at->format('d M Y H:i') }}</dd>
                    </div>
                @endif
                @if($donation->status === 'rejected' && $donation->admin_notes)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Catatan Admin</dt>
                        <dd class="mt-1 text-sm text-red-600">{{ $donation->admin_notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="px-6 py-4">
            <dt class="mb-2 text-sm font-medium text-gray-500">Bukti Transfer</dt>
            <dd>
                <a href="{{ Storage::disk('public')->url($donation->proof_image_path) }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ Storage::disk('public')->url($donation->proof_image_path) }}"
                         alt="Bukti Transfer"
                         class="max-w-md rounded-md shadow hover:opacity-75 transition-opacity cursor-pointer">
                </a>
            </dd>
        </div>
    </x-admin.card>

    @if($donation->status === 'pending')
    <div class="mt-6 flex gap-x-3">
        <form action="{{ route('admin.donations.verify', $donation) }}" method="POST">
            @csrf
            <x-admin.button variant="success" type="submit">
                Verifikasi Donasi
            </x-admin.button>
        </form>

        <button type="button" onclick="document.getElementById('reject-form').classList.toggle('hidden')"
                class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
            Tolak Donasi
        </button>
    </div>

    <div id="reject-form" class="mt-4 hidden">
        <form action="{{ route('admin.donations.reject', $donation) }}" method="POST" class="space-y-4 rounded-lg border border-red-200 bg-red-50 p-4">
            @csrf
            <div>
                <label for="admin_notes" class="block text-sm font-medium text-gray-900">Alasan Penolakan</label>
                <div class="mt-2">
                    <x-admin.input type="textarea" name="admin_notes" rows="3" placeholder="Jelaskan alasan donasi ditolak..." />
                </div>
                @error('admin_notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <x-admin.button variant="danger" type="submit">
                Konfirmasi Penolakan
            </x-admin.button>
        </form>
    </div>
    @endif
</div>
@endsection
