@props([
    'is_active' => false,
    'url' => '',
    'icon' => null,
    'title' => 'Link'
])

@php

$activeClass = ' font-bold group-hover:text-zinc-900 bg-indigo-600 text-white';

$classes = 'group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-indigo-600 hover:text-white '
    . ($is_active ? $activeClass : ' text-zinc-900 ');

@endphp

<a href="{{ $url }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if ($is_active)
        <x-icon name="{{ $icon }}" class="h-5 w-5 text-white group-hover:text-white"/>
    @else
        <x-icon name="{{ $icon }}" class="h-5 w-5 text-zinc-500 group-hover:text-white"/>
    @endif
    {{ $slot }}
</a>
