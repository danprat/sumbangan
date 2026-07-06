@props([])

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'min-w-full text-left text-body-md text-on-background']) }}>
        {{ $slot }}
    </table>
</div>
