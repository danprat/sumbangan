@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => null,
    'rows' => null,
])

@php
$id = $id ?? $name;
$baseClasses = 'block w-full rounded-xl border border-outline-variant bg-surface-container-lowest px-4 py-3 text-body-md text-on-background placeholder:text-on-surface-variant/80 shadow-sm transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20';
@endphp

@if ($type === 'textarea')
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows ?? 3 }}"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >{{ old($name, $value) }}</textarea>
@elseif ($type === 'file')
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-xl border border-dashed border-outline-variant bg-surface-container-low px-4 py-3 text-body-md text-on-surface-variant file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2 file:text-label-md file:font-semibold file:text-on-primary hover:file:bg-primary-container hover:file:text-on-primary-container']) }}
    />
@else
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    />
@endif
