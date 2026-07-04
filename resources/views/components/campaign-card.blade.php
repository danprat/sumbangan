@props(['campaign'])

<div class="group relative flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
    <div class="aspect-[4/3] w-full overflow-hidden bg-gray-50 relative">
        @if($campaign->image_path)
            <img src="{{ Storage::disk('public')->url($campaign->image_path) }}"
                 alt="{{ $campaign->title }}"
                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50">
                <svg class="w-16 h-16 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
        @endif
        @if($campaign->isCompleted())
            <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-semibold text-gray-700 shadow-sm">
                Selesai
            </div>
        @else
            <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-semibold text-indigo-600 shadow-sm">
                {{ $campaign->remainingDays() }} Hari Lagi
            </div>
        @endif
    </div>

    <div class="p-6 flex flex-col flex-grow">
        <h3 class="text-xl font-bold text-gray-900 line-clamp-2 mb-2 group-hover:text-indigo-600 transition-colors">
            <a href="{{ route('campaigns.show', $campaign->slug) }}" class="focus:outline-none">
                <span class="absolute inset-0" aria-hidden="true"></span>
                {{ $campaign->title }}
            </a>
        </h3>

        <div class="mt-auto pt-4">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Terkumpul</p>
                    <p class="font-bold text-indigo-600">Rp {{ number_format($campaign->totalVerifiedAmount(), 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Target</p>
                    <p class="text-sm font-medium text-gray-700">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="relative w-full rounded-full bg-gray-100 h-2 mt-4 overflow-hidden">
                <div class="absolute top-0 left-0 h-full rounded-full transition-all duration-1000 ease-out {{ $campaign->progressPercentage() >= 100 ? 'bg-emerald-500' : 'bg-gradient-to-r from-indigo-500 to-purple-500' }}"
                     style="width: {{ $campaign->progressPercentage() }}%"></div>
            </div>

            <div class="mt-4 flex items-center justify-between">
                 <span class="text-sm font-semibold text-gray-700">{{ $campaign->progressPercentage() }}%</span>
                 <span class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 group-hover:translate-x-1 transition-transform">
                     Donasi <span aria-hidden="true">&rarr;</span>
                 </span>
            </div>
        </div>
    </div>
</div>
