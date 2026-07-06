@props(['type' => 'success'])

@php
$types = [
    'success' => 'rounded-xl border border-secondary/20 bg-secondary-container/60 px-4 py-3 text-body-md text-on-secondary-container',
    'error' => 'rounded-xl border border-error/20 bg-error-container px-4 py-3 text-body-md text-on-error-container',
];

$typeClasses = $types[$type] ?? $types['success'];
@endphp

<div {{ $attributes->merge(['class' => $typeClasses]) }}>
    {{ $slot }}
</div>
