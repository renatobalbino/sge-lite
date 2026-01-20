@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex overflow-hidden text-zinc-900 font-sans">

<aside class="hidden w-64 flex-col border-r border-zinc-200 bg-white md:flex">

    <div class="flex h-16 items-center border-b border-zinc-100 px-6">
        <span class="text-lg font-bold tracking-tight text-indigo-600">GestorSaaS</span>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <a href="#" class="group flex items-center gap-3 rounded-lg bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-900">
            <x-icon name="home" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900"/>
            Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900">
            <x-icon name="document-text" class="h-5 w-5 text-zinc-400 group-hover:text-zinc-500"/>
            Produtos
        </a>

        <a href="{{ route('admin.quotes.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900">
            <x-icon name="document-text" class="h-5 w-5 text-zinc-400 group-hover:text-zinc-500"/>
            Orçamentos
        </a>

        <a href="#" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900">
            <x-icon name="users" class="h-5 w-5 text-zinc-400 group-hover:text-zinc-500"/>
            Clientes
        </a>
    </nav>

    <div class="border-t border-zinc-200 p-4">
        <div class="flex items-center gap-3">
            <img class="h-9 w-9 rounded-full bg-zinc-100" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="">
            <div class="text-sm">
                <p class="font-medium text-zinc-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-zinc-500">{{ Auth::user()->currentPlan->name ?? 'Plano Exemplo' }}</p>
            </div>
        </div>
    </div>
</aside>

<main class="flex flex-1 flex-col overflow-hidden">

    <header class="flex h-16 items-center justify-between gap-4 border-b border-zinc-200 bg-white px-6">
        <div class="flex items-center gap-2 text-sm text-zinc-500">
            <span>🏠</span>
            <span class="text-zinc-300">/</span>
            <h1 class="font-semibold text-zinc-900">{{ $header ?? '' }}</h1>
        </div>

        <div class="flex items-center gap-3">
            <button class="rounded-full p-2 text-zinc-400 hover:bg-zinc-100 hover:text-zinc-500">
                <x-icon name="bell" class="h-5 w-5"/>
            </button>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto bg-zinc-50 p-6 md:p-8">
        <div class="mx-auto max-w-6xl">
            {{ $slot }}
        </div>
    </div>
</main>

@stack('scripts')
</body>
</html>
