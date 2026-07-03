@props(['campaign'])

<div class="group relative overflow-hidden rounded-lg bg-white shadow-md transition hover:shadow-lg">
    <div class="aspect-video w-full overflow-hidden bg-gray-100">
        @if($campaign->image_path)
            <img src="{{ Storage::disk('public')->url($campaign->image_path) }}"
                 alt="{{ $campaign->title }}"
                 class="h-full w-full object-cover">
        @else
            <div class="flex h-full w-full items-center justify-center bg-indigo-50">
                <span class="text-4xl">🎁</span>
            </div>
        @endif
    </div>

    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $campaign->title }}</h3>

        <div class="mt-3">
            <div class="flex items-center justify-between text-sm">
                <span class="font-semibold text-indigo-600">Rp {{ number_format($campaign->totalVerifiedAmount(), 0, ',', '.') }}</span>
                <span class="text-gray-500">dari Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
            </div>

            <div class="mt-2 w-full rounded-full bg-gray-200 h-2.5">
                <div class="h-2.5 rounded-full {{ $campaign->progressPercentage() >= 100 ? 'bg-green-500' : 'bg-indigo-600' }}"
                     style="width: {{ $campaign->progressPercentage() }}%"></div>
            </div>

            <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                <span>{{ $campaign->progressPercentage() }}% tercapai</span>
                @if($campaign->isCompleted())
                    <span class="text-gray-400">Selesai</span>
                @else
                    <span>{{ $campaign->remainingDays() }} hari lagi</span>
                @endif
            </div>
        </div>

        <a href="{{ route('campaigns.show', $campaign->slug) }}"
           class="mt-4 block w-full rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
            {{ $campaign->isCompleted() ? 'Lihat Detail' : 'Donasi Sekarang' }}
        </a>
    </div>
</div>
