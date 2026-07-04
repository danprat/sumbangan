@props([
    'variant' => 'primary',
    'as' => 'button',
    'type' => 'submit',
    'href' => null,
])

@php
$base = 'inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 shadow-sm';

$variants = [
    'primary' => 'bg-indigo-600 text-white hover:bg-indigo-500',
    'secondary' => 'bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50',
    'success' => 'bg-emerald-600 text-white hover:bg-emerald-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-500',
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
