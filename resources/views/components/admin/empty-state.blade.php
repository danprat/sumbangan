@props([])

<div {{ $attributes->merge(['class' => 'p-6 text-center text-sm text-gray-500']) }}>
    {{ $slot }}
</div>
