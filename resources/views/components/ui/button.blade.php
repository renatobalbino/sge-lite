@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-medium transition-all rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:opacity-50 disabled:pointer-events-none';

    // Verifique se todas as chaves estão entre aspas simples e com vírgula no final
    $variants = [
        'primary'   => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 shadow-sm',
        'secondary' => 'bg-white text-zinc-700 border border-zinc-200 hover:bg-zinc-50 hover:border-zinc-300 focus:ring-zinc-200 shadow-sm',
        'danger'    => 'bg-white text-red-600 border border-red-200 hover:bg-red-50 focus:ring-red-500',
        'ghost'     => 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900 border border-transparent',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
    ];

    // Fallback: Se a variante digitada não existir, usa 'primary' para não quebrar
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];

    $classes = $baseClasses . ' ' . $variantClass . ' ' . $sizeClass;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            {{-- Se instalou o blade-heroicons, use assim: --}}
{{--            <x-dynamic-component :component="'heroicon-o-'.$icon" class="w-4 h-4" />--}}
            <x-ui.icon :name="$icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
        @if($icon)
            {{-- Se instalou o blade-heroicons, use assim: --}}
{{--            <x-dynamic-component :component="'heroicon-o-'.$icon" class="w-4 h-4" />--}}
            <x-ui.icon :name="$icon" class="w-4 h-4" />
        @endif
        {{ $slot }}
    </button>
@endif
