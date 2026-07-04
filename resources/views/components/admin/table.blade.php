@props([])

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full text-sm text-left text-gray-700']) }}>
        {{ $slot }}
    </table>
</div>
