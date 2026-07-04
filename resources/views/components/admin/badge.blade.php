@props(['status'])

@php
$statuses = [
    'pending' => 'bg-amber-100 text-amber-700',
    'verified' => 'bg-emerald-100 text-emerald-700',
    'rejected' => 'bg-rose-100 text-rose-700',
    'neutral' => 'bg-gray-100 text-gray-700',
];

$statusClasses = $statuses[$status] ?? $statuses['pending'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2 py-1 text-xs font-medium $statusClasses"]) }}>
    {{ $slot }}
</span>
