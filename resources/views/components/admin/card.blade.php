@props([])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-outline-variant/40 bg-surface-container-lowest shadow-[0px_4px_20px_rgba(0,0,0,0.04)]']) }}>
    {{ $slot }}
</div>
