@extends('layouts.admin')

@section('title', 'Detail Donasi')

@section('content')
<div class="max-w-4xl space-y-lg">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-display-lg-mobile font-display-lg text-on-background">Detail Donasi</h1>
            <p class="mt-2 text-body-md text-on-surface-variant">Lihat detail donatur, bukti transfer, dan lakukan verifikasi dengan tampilan yang lebih jelas.</p>
        </div>
        <x-admin.button as="a" href="{{ route('admin.donations.index') }}" variant="secondary">Kembali</x-admin.button>
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
        <x-admin.card class="p-6">
            <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Donatur</dt>
                    <dd class="mt-2 text-body-md text-on-background">{{ $donation->donor_name }}</dd>
                </div>
                <div>
                    <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Email / Telepon</dt>
                    <dd class="mt-2 text-body-md text-on-background">{{ $donation->donor_email ?? '-' }} / {{ $donation->donor_phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Campaign</dt>
                    <dd class="mt-2 text-body-md text-on-background">{{ $donation->campaign?->title }}</dd>
                </div>
                <div>
                    <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Nominal</dt>
                    <dd class="mt-2 text-headline-md font-headline-md text-on-background">Rp {{ number_format($donation->amount, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Status</dt>
                    <dd class="mt-2">
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
                    <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Tanggal Donasi</dt>
                    <dd class="mt-2 text-body-md text-on-background">{{ $donation->created_at->format('d M Y H:i') }}</dd>
                </div>
                @if($donation->status === 'verified')
                    <div>
                        <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Tanggal Verifikasi</dt>
                        <dd class="mt-2 text-body-md text-on-background">{{ $donation->verified_at->format('d M Y H:i') }}</dd>
                    </div>
                @endif
                @if($donation->status === 'rejected' && $donation->admin_notes)
                    <div class="sm:col-span-2 rounded-xl border border-error/20 bg-error-container p-4">
                        <dt class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-error-container">Catatan Admin</dt>
                        <dd class="mt-2 text-body-md text-on-error-container">{{ $donation->admin_notes }}</dd>
                    </div>
                @endif
            </dl>
        </x-admin.card>

        <x-admin.card class="p-6">
            <p class="text-label-sm font-label-sm uppercase tracking-[0.14em] text-on-surface-variant">Bukti Transfer</p>
            <div class="mt-4 overflow-hidden rounded-xl border border-outline-variant/40 bg-surface-container-low">
                <a href="{{ Storage::disk('public')->url($donation->proof_image_path) }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ Storage::disk('public')->url($donation->proof_image_path) }}" alt="Bukti Transfer" class="h-full max-h-[420px] w-full object-cover transition-opacity hover:opacity-90">
                </a>
            </div>
            <p class="mt-3 text-label-sm text-on-surface-variant">Klik gambar untuk membuka ukuran penuh.</p>
        </x-admin.card>
    </div>

    @if($donation->status === 'pending')
    <div class="space-y-4">
        <div class="flex flex-col gap-3 sm:flex-row">
            <form action="{{ route('admin.donations.verify', $donation) }}" method="POST">
                @csrf
                <x-admin.button variant="success" type="submit">
                    Verifikasi Donasi
                </x-admin.button>
            </form>

            <x-admin.button as="button" type="button" variant="danger" onclick="document.getElementById('reject-form').classList.toggle('hidden')">
                Tolak Donasi
            </x-admin.button>
        </div>

        <div id="reject-form" class="hidden">
            <x-admin.card class="border-error/20 bg-error-container/50 p-6">
                <form action="{{ route('admin.donations.reject', $donation) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="admin_notes" class="block text-label-md font-label-md text-on-background">Alasan Penolakan</label>
                        <div class="mt-2">
                            <x-admin.input type="textarea" name="admin_notes" rows="3" placeholder="Jelaskan alasan donasi ditolak..." />
                        </div>
                        @error('admin_notes') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
                    </div>
                    <x-admin.button variant="danger" type="submit">
                        Konfirmasi Penolakan
                    </x-admin.button>
                </form>
            </x-admin.card>
        </div>
    </div>
    @endif
</div>
@endsection
