@php
    // Helper simples para classes ativas
    $navClass = fn($route) => request()->routeIs($route)
        ? 'bg-zinc-100 text-zinc-900 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors'
        : 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors';
@endphp

<div class="text-xs font-semibold leading-6 text-zinc-400 mb-2">Menu</div>

<x-ui.link icon="home" url="{{ route('admin.dashboard') }}" :is_active="request()->routeIs('admin.dashboard')">Dashboard</x-ui.link>
<x-ui.link icon="shopping-bag" url="{{ route('admin.products.index') }}" :is_active="request()->routeIs('admin.products.*')">Produtos</x-ui.link>
<x-ui.link icon="document-text" url="{{ route('admin.quotes.index') }}" :is_active="request()->routeIs('admin.quotes.*')">Orçamentos</x-ui.link>
<x-ui.link icon="users" url="{{ route('admin.clients.index') }}" :is_active="request()->routeIs('admin.clients.*')">Clientes</x-ui.link>

<div class="text-xs font-semibold leading-6 text-zinc-400 my-2">Operacional</div>

<x-ui.link icon="chart-bar" url="{{ route('admin.clients.index') }}" :is_active="request()->routeIs('admin.clients.*')">Relatórios</x-ui.link>
