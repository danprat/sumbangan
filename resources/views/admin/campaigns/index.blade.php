@extends('layouts.admin')

@section('title', 'Campaign')

@section('content')
<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Campaign</h1>
            <p class="mt-1 text-sm text-gray-500">Daftar campaign penggalangan dana.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <x-admin.button as="a" href="{{ route('admin.campaigns.create') }}" variant="primary">
                Buat Campaign
            </x-admin.button>
        </div>
    </div>

    <x-admin.card class="mt-8 overflow-hidden">
        @if($campaigns->isEmpty())
            <x-admin.empty-state>
                Belum ada campaign. Klik "Buat Campaign" untuk memulai.
            </x-admin.empty-state>
        @else
            <x-admin.table>
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deadline</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($campaigns as $campaign)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $campaign->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="flex items-center gap-x-2">
                                <div class="w-24 rounded-full bg-gray-200 h-2">
                                    <div class="h-2 rounded-full {{ $campaign->progressPercentage() >= 100 ? 'bg-green-500' : 'bg-indigo-600' }}"
                                         style="width: {{ $campaign->progressPercentage() }}%"></div>
                                </div>
                                <span>{{ $campaign->progressPercentage() }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($campaign->deadline)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($campaign->isCompleted())
                                <x-admin.badge status="neutral">Selesai</x-admin.badge>
                            @else
                                <x-admin.badge status="verified">Aktif</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-right space-x-3">
                            <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="text-indigo-600 hover:text-indigo-500">Edit</a>
                            <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" class="inline" onsubmit="return confirm('Hapus campaign ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>
        @endif
    </x-admin.card>
</div>
@endsection
