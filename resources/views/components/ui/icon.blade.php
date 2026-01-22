@props(['name'])

{{-- Exemplo simples usando SVG inline ou lógica para buscar svg --}}
@php
    // Mapeamento manual temporário para testar
    $icons = [
        'arrow-down-tray' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />',
        'arrow-left' => '<path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
        'edit' => '<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />',
        'plus' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />',
    ];
@endphp

<svg {{ $attributes->merge(['class' => 'w-5 h-5', 'fill' => 'none', 'viewBox' => '0 0 24 24', 'stroke-width' => '1.5', 'stroke' => 'currentColor']) }} xmlns="http://www.w3.org/2000/svg">
    {!! $icons[$name] ?? '' !!}
</svg>
