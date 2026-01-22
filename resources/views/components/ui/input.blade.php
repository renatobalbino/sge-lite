@props([
    'label' => '',
    'type' => 'text',
    'labelClass' => 'block text-sm font-medium text-gray-700'
])

@php

$defaultClasses = 'block w-full mt-1 px-3 py-2  block w-full rounded-md border-1 border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';
$attributes = $attributes->merge(['type' => 'text', 'class' => $defaultClasses]);

@endphp

<div>
    <label class="{{ $labelClass }}">{{ $label }}</label>

    @if ($type !== 'textarea')
        <input type="{{ $type }}" {{ $attributes }}>
    @else
        <textarea {{ $attributes }}></textarea>
    @endif
</div>
