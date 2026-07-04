@props([])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-gray-200 bg-white shadow-sm']) }}>
    {{ $slot }}
</div>
