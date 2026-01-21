@props([
    'is_active' => false,
    'url' => '',
    'icon' => null,
    'title' => 'Link'
])

@php

$activeClass = 'font-bold group-hover:text-zinc-900';

$classes = 'group flex items-center gap-3 rounded-lg bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-900 '
    . ($is_active ? $activeClass : '');

@endphp

<div>
    <a href="{{ $url }}" {{ $attributes->class($classes) }}>
        <x-icon name="{{ $icon }}" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900"/>
        {{ $title ?? 'Link'}}
    </a>
</div>
