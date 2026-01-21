@props([
    'label' => '',
    'type' => 'text',
])

@php

$defaultClasses = 'block w-full pl-10 pr-3 py-2  block w-full rounded-md border-1 border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';
$attributes = $attributes->merge(['type' => 'text', 'class' => $defaultClasses]);

@endphp

<div class="relative flex-1">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        {{ $slot }}
    </div>
{{--    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>--}}

    @if ($type !== 'textarea')
        <input type="text" {{ $attributes }}>
    @else
        <textarea {{ $attributes }}></textarea>
    @endif
</div>
