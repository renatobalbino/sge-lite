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

<aside class="hidden w-64 flex-col border-r border-zinc-200 bg-gray-100 md:flex">

    <div class="flex h-16 items-center border-b border-zinc-200 px-6">
        <span class="text-lg font-bold tracking-tight text-indigo-600">GestorSaaS</span>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <x-ui.link :title="'Dashboard'" :icon="'home'" :is_active={{ request()->routeIs('admin.dashboard') }}/>
        <x-ui.link :title="'Produtos'" :icon="'document-text'" :url="{{ route('admin.products.index') }}" :is_active={{ request()->routeIs('admin.products.*') }} />

{{--        <a href="#" class="group flex items-center gap-3 rounded-lg bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-900">--}}
{{--            <x-icon name="home" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900"/>--}}
{{--            Dashboard--}}
{{--        </a>--}}

{{--        <a href="{{ route('admin.products.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900">--}}
{{--            <x-icon name="document-text" class="h-5 w-5 text-zinc-400 group-hover:text-zinc-500"/>--}}
{{--            Produtos--}}
{{--        </a>--}}

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

    <div class="flex-1 overflow-y-auto bg-zinc-50 p-6 md:p-6">
        <div class="mx-auto w-full">
            {{ $slot }}
        </div>
    </div>
</main>

<div
    x-data="{
        notifications: [],
        add(e) {
            // Cria um ID único real para evitar conflito em disparos simultâneos
            const id = Date.now() + Math.floor(Math.random() * 1000);

            this.notifications.push({
                id: id,
                message: e.detail.message,
                style: e.detail.style || 'success',
            });

            // Remove este toast específico após 5 segundos
            setTimeout(() => {
                this.remove(id);
            }, 5000);
        },
        remove(id) {
            // Filtra o array mantendo apenas os que não têm o ID removido
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }"
    @notify.window="add($event)"
    class="fixed top-4 right-4 z-50 flex flex-col gap-2 w-full max-w-sm pointer-events-none shadow-md"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8 scale-90"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="pointer-events-auto relative w-full shadow-lg rounded-lg border-l-4 p-4 flex items-start hover:cursor-pointer"
            :class="{
                'border-green-500 bg-green-100': notification.style === 'success',
                'border-red-500 bg-red-100': notification.style === 'error',
                'border-blue-500 bg-blue-100': notification.style === 'info',
            }"
            @click="remove(notification.id)"
        >
            <div class="shrink-0">
                <template x-if="notification.style === 'success'">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </template>
                <template x-if="notification.style === 'error'">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </template>
                <template x-if="notification.style === 'info'">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </template>
            </div>

            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900 leading-snug" x-text="notification.message"></p>
            </div>
        </div>
    </template>
</div>

<script>
    document.addEventListener('livewire:navigated', () => {
        // Verifica se existe mensagem na sessão flash do Laravel
        @if (session()->has('message'))
        window.dispatchEvent(new CustomEvent('notify', {
            detail: {
                message: "{{ session('message') }}",
                style: 'success'
            }
        }));
        @endif

        @if (session()->has('error'))
        window.dispatchEvent(new CustomEvent('notify', {
            detail: {
                message: "{{ session('info') }}",
                style: 'info'
            }
        }));
        @endif

        @if (session()->has('error'))
        window.dispatchEvent(new CustomEvent('notify', {
            detail: {
                message: "{{ session('error') }}",
                style: 'error'
            }
        }));
        @endif
    });
</script>

@stack('scripts')
</body>
</html>
