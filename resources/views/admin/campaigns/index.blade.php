@extends('layouts.admin')

@section('title', 'Campaign')

@section('content')
<div class="space-y-lg">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-display-lg-mobile font-display-lg text-on-background">Campaign</h1>
            <p class="mt-2 text-body-md text-on-surface-variant">Daftar campaign penggalangan dana yang sedang dikelola tim admin.</p>
        </div>
        <x-admin.button as="a" href="{{ route('admin.campaigns.create') }}" variant="primary">
            <span class="material-symbols-outlined text-lg">add</span>
            Buat Campaign
        </x-admin.button>
    </div>

    <x-admin.card class="overflow-hidden">
        @if($campaigns->isEmpty())
            <x-admin.empty-state>
                Belum ada campaign. Klik "Buat Campaign" untuk memulai.
            </x-admin.empty-state>
        @else
            <x-admin.table>
                <thead class="bg-surface-container-low text-label-sm font-label-sm uppercase text-on-surface-variant">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Judul</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Target</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Progress</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Deadline</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/40">
                    @foreach($campaigns as $campaign)
                    <tr class="hover:bg-surface-container/30 transition-colors">
                        <td class="px-6 py-5">
                            <div class="font-semibold text-on-background">{{ $campaign->title }}</div>
                        </td>
                        <td class="px-6 py-5 text-on-surface-variant">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="h-2 w-24 overflow-hidden rounded-full bg-surface-variant">
                                    <div class="h-2 rounded-full {{ $campaign->progressPercentage() >= 100 ? 'bg-secondary' : 'bg-primary' }}" style="width: {{ $campaign->progressPercentage() }}%"></div>
                                </div>
                                <span class="text-label-md font-label-md text-on-background">{{ $campaign->progressPercentage() }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-on-surface-variant">{{ \Carbon\Carbon::parse($campaign->deadline)->format('d M Y') }}</td>
                        <td class="px-6 py-5">
                            @if($campaign->isCompleted())
                                <x-admin.badge status="neutral">Selesai</x-admin.badge>
                            @else
                                <x-admin.badge status="verified">Aktif</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-4 text-label-md font-label-md">
                                <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="text-primary transition-colors hover:text-primary-container">Edit</a>
                                <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Hapus campaign ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error transition-colors hover:opacity-80">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>
        @endif
    </x-admin.card>
</div>
@endsection
