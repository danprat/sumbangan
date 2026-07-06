@props([])

<div {{ $attributes->merge(['class' => 'flex min-h-56 flex-col items-center justify-center gap-3 px-6 py-10 text-center text-body-md text-on-surface-variant']) }}>
    <span class="material-symbols-outlined text-4xl text-primary/70">inbox</span>
    <div class="max-w-md">{{ $slot }}</div>
</div>
