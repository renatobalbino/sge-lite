<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Loja Virtual' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex flex-col min-h-full font-sans text-zinc-900">

<div class="bg-zinc-900 px-4 py-2.5 text-center text-xs font-medium text-white sm:px-6 lg:px-8">
    <p>🎉 Frete Grátis para pedidos acima de R$ 200,00 | <a href="#" class="underline hover:text-indigo-300">Ver regras</a></p>
</div>

<header class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-md border-b border-zinc-200" x-data="{ mobileMenuOpen: false }">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:px-8" aria-label="Global">

        <div class="flex lg:flex-1">
            <a href="{{ route('shop.catalog') }}" class="-m-1.5 p-1.5 font-bold text-xl tracking-tight text-indigo-600">
                Store<span class="text-zinc-900">Front</span>
            </a>
        </div>

        <div class="hidden lg:flex lg:gap-x-8 mr-8">
            <a href="{{ route('shop.catalog') }}" class="text-sm font-semibold leading-6 text-zinc-900 hover:text-indigo-600 transition-colors">Todos os Produtos</a>
            <a href="#" class="text-sm font-semibold leading-6 text-zinc-500 hover:text-indigo-600 transition-colors">Ofertas</a>
            <a href="#" class="text-sm font-semibold leading-6 text-zinc-500 hover:text-indigo-600 transition-colors">Lançamentos</a>
        </div>

        <div class="flex flex-1 items-center justify-end gap-x-6">

            <div class="hidden lg:block relative max-w-xs w-full">
                <input
                    type="text"
                    class="block w-full rounded-full border-0 py-1.5 pl-3 pr-10 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 placeholder:text-zinc-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-zinc-50/50"
                    placeholder="O que você procura?"
                >
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-icon name="magnifying-glass" class="h-4 w-4 text-zinc-400" />
                </div>
            </div>

            <div class="hidden lg:block h-6 w-px bg-zinc-200" aria-hidden="true"></div>

            <a href="#" class="hidden lg:block text-sm font-semibold leading-6 text-zinc-900">Entrar</a>

            <button
                x-data
                @click="$dispatch('open-cart')"
                class="group -m-2.5 p-2.5 text-zinc-700 hover:text-indigo-600 flex items-center gap-2"
            >
                <span class="sr-only">Abrir carrinho</span>
                <div class="relative">
                    <x-icon name="shopping-bag" class="h-6 w-6" />
                    <livewire:shop.cart-counter />
                </div>
            </button>
        </div>

        <div class="flex lg:hidden ml-4">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-zinc-700" @click="mobileMenuOpen = true">
                <span class="sr-only">Abrir menu</span>
                <x-icon name="bars-3" class="h-6 w-6" />
            </button>
        </div>
    </nav>

    <div x-show="mobileMenuOpen" class="lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-50 bg-black/20 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>
        <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-zinc-900/10">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5 font-bold text-xl text-indigo-600">
                    Store<span class="text-zinc-900">Front</span>
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-zinc-700" @click="mobileMenuOpen = false">
                    <span class="sr-only">Fechar menu</span>
                    <x-icon name="x-mark" class="h-6 w-6" />
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-zinc-500/10">
                    <div class="space-y-2 py-6">
                        <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-zinc-900 hover:bg-zinc-50">Produtos</a>
                        <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-zinc-900 hover:bg-zinc-50">Minha Conta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="flex-auto">
    {{ $slot }}
</main>

<footer class="bg-white border-t border-zinc-200 mt-auto" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-4">
                <span class="text-lg font-bold text-zinc-900">Sua Marca</span>
                <p class="text-sm leading-6 text-zinc-500 max-w-xs">
                    Trazendo os melhores produtos para você com a qualidade que você confia.
                </p>
                <div class="flex space-x-4 grayscale opacity-60">
                    <div class="h-6 w-6 bg-zinc-200 rounded-full"></div>
                    <div class="h-6 w-6 bg-zinc-200 rounded-full"></div>
                </div>
            </div>
            <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold leading-6 text-zinc-900">Loja</h3>
                        <ul role="list" class="mt-6 space-y-4">
                            <li><a href="#" class="text-sm leading-6 text-zinc-600 hover:text-zinc-900">Novidades</a></li>
                            <li><a href="#" class="text-sm leading-6 text-zinc-600 hover:text-zinc-900">Mais Vendidos</a></li>
                        </ul>
                    </div>
                    <div class="mt-10 md:mt-0">
                        <h3 class="text-sm font-semibold leading-6 text-zinc-900">Suporte</h3>
                        <ul role="list" class="mt-6 space-y-4">
                            <li><a href="#" class="text-sm leading-6 text-zinc-600 hover:text-zinc-900">Rastrear Pedido</a></li>
                            <li><a href="#" class="text-sm leading-6 text-zinc-600 hover:text-zinc-900">Devoluções</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-zinc-900/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs leading-5 text-zinc-500">&copy; {{ date('Y') }} Sua Empresa Ltda. Todos os direitos reservados.</p>
            <div class="flex gap-2 opacity-50 grayscale">
                <div class="h-6 w-10 bg-zinc-200 rounded"></div> <div class="h-6 w-10 bg-zinc-200 rounded"></div> <div class="h-6 w-10 bg-zinc-200 rounded"></div> </div>
        </div>
    </div>
</footer>

<div
    x-data="{ notifications: [], add(e) { this.notifications.push({id: Date.now(), type: e.detail.type ?? 'success', message: e.detail.message, show: true}); setTimeout(() => { this.remove(this.notifications.length - 1) }, 3000); }, remove(index) { if (this.notifications[index]) this.notifications[index].show = false; } }"
    @notify.window="add($event)"
    class="fixed bottom-0 right-0 z-50 p-4 space-y-3 pointer-events-none"
>
    <template x-for="(note, index) in notifications" :key="note.id">
        <div x-show="note.show" x-transition class="pointer-events-auto w-full max-w-sm rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 flex items-center p-4 gap-3">
            <div class="flex-1 text-sm font-medium text-zinc-900" x-text="note.message"></div>
        </div>
    </template>
</div>

@livewireScriptConfig
</body>
</html>
