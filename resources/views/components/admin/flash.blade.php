@props(['type' => 'success'])

@php
$types = [
    'success' => 'rounded-md bg-emerald-50 p-4 text-sm text-emerald-700 border border-emerald-200',
    'error' => 'rounded-md bg-red-50 p-4 text-sm text-red-700 border border-red-200',
];

$typeClasses = $types[$type] ?? $types['success'];
@endphp

<div {{ $attributes->merge(['class' => $typeClasses]) }}>
    {{ $slot }}
</div>
