@php
    // Helper simples para classes ativas
    $navClass = fn($route) => request()->routeIs($route)
        ? 'bg-zinc-100 text-zinc-900 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors'
        : 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors';
@endphp

<a href="{{ route('dashboard') }}" class="{{ $navClass('dashboard') }}">
    <x-icon name="home" class="h-6 w-6 shrink-0 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-zinc-400 group-hover:text-zinc-600' }}" />
    Dashboard
</a>

<div class="text-xs font-semibold leading-6 text-zinc-400 mt-4 mb-2">Comercial</div>

<a href="{{ route('admin.quotes.index') }}" class="{{ $navClass('quotes.*') }}">
    <x-icon name="document-text" class="h-6 w-6 shrink-0 {{ request()->routeIs('quotes.*') ? 'text-indigo-600' : 'text-zinc-400 group-hover:text-zinc-600' }}" />
    Orçamentos
</a>

<a href="{{ route('admin.products.index') }}" class="{{ $navClass('products.*') }}">
    <x-icon name="shopping-bag" class="h-6 w-6 shrink-0 {{ request()->routeIs('products.*') ? 'text-indigo-600' : 'text-zinc-400 group-hover:text-zinc-600' }}" />
    Catálogo & Pedidos
</a>

<div class="text-xs font-semibold leading-6 text-zinc-400 mt-4 mb-2">Operacional</div>
