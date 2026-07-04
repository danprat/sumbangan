@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => null,
    'rows' => null,
])

@php
$id = $id ?? $name;
@endphp

@if ($type === 'textarea')
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows ?? 3 }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm']) }}
    >{{ old($name, $value) }}</textarea>
@elseif ($type === 'file')
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->merge(['class' => 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100']) }}
    />
@else
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm']) }}
    />
@endif
