@props([
    'variant' => 'primary',
    'as' => 'button',
    'type' => 'submit',
    'href' => null,
])

@php
$base = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-label-md font-label-md font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-60';

$variants = [
    'primary' => 'bg-primary text-on-primary shadow-sm hover:bg-primary-container hover:text-on-primary-container',
    'secondary' => 'border border-outline-variant bg-surface-container-lowest text-on-background hover:bg-surface-container',
    'success' => 'bg-secondary text-on-secondary shadow-sm hover:opacity-90',
    'danger' => 'bg-error text-on-error shadow-sm hover:opacity-90',
];

$variantClasses = $variants[$variant] ?? $variants['primary'];
@endphp

@if ($as === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $variantClasses"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $variantClasses"]) }}>
        {{ $slot }}
    </button>
@endif
