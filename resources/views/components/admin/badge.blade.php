@props(['status'])

@php
$statuses = [
    'pending' => 'bg-[#fff3cd] text-[#856404]',
    'verified' => 'bg-secondary-container text-on-secondary-container',
    'rejected' => 'bg-error-container text-on-error-container',
    'neutral' => 'bg-surface-container text-on-surface-variant',
];

$statusClasses = $statuses[$status] ?? $statuses['pending'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-3 py-1 text-label-sm font-label-sm $statusClasses"]) }}>
    {{ $slot }}
</span>
