<div
    x-data="{
        cartOpen: false,
        toggleCart() {
            this.cartOpen = !this.cartOpen
            alert('clicou')
        }
    }"
    @open-cart.window="cartOpen = true"
    @keydown.escape.window="cartOpen = false"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="sticky top-0 z-20 bg-zinc-50/95 backdrop-blur border-b border-zinc-200 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-hide">

                    <button
                        wire:click="$set('selectedTag', null)"
                        class="whitespace-nowrap rounded-full px-4 py-1.5 text-sm font-medium transition-all
                {{ is_null($selectedTag)
                    ? 'bg-zinc-900 text-white shadow-md ring-1 ring-zinc-900'
                    : 'bg-white text-zinc-600 ring-1 ring-zinc-200 hover:bg-zinc-100'
                }}"
                    >
                        Todos
                    </button>

                    @foreach($allTags as $tag)
                        <button
                            wire:click="toggleTag('{{ $tag->slug }}')"
                            class="whitespace-nowrap rounded-full px-4 py-1.5 text-sm font-medium transition-all flex items-center gap-1.5
                    {{ $selectedTag === $tag->slug
                        ? 'bg-indigo-600 text-white shadow-md ring-1 ring-indigo-600'
                        : 'bg-white text-zinc-600 ring-1 ring-zinc-200 hover:bg-zinc-50 hover:text-zinc-900'
                    }}"
                        >
                            @php
                                $colors = [
                                    'red' => 'bg-red-500',
                                    'blue' => 'bg-blue-500',
                                    'green' => 'bg-emerald-500',
                                    'purple' => 'bg-purple-500',
                                    'zinc' => 'bg-zinc-500',
                                ];
                                $dotColor = $colors[$tag->color] ?? 'bg-zinc-400';
                            @endphp
                            <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                            {{ $tag->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-20">
                <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-zinc-100 mb-4">
                    <x-icon name="face-frown" class="w-8 h-8 text-zinc-400" />
                </div>
                <h3 class="text-lg font-medium text-zinc-900">Nenhum produto encontrado</h3>
                <p class="text-zinc-500">Tente buscar por outro termo.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-10 gap-x-6 xl:gap-x-8">
                @foreach($products as $product)
                    <div class="group relative bg-white rounded-2xl p-3 hover:shadow-xl transition-all duration-300 border border-transparent hover:border-zinc-200/60 ring-1 ring-zinc-900/5">
                        <div class="aspect-4/3 w-full overflow-hidden rounded-xl bg-zinc-200 relative">
                            @if($product->cover_image)
                                <img src="{{ $product->cover_image }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-zinc-400">
                                    <x-icon name="photo" class="w-12 h-12 opacity-20" />
                                </div>
                            @endif

                            <div class="absolute z-10 bottom-3 right-3 opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                <button
                                    wire:click="addToCart('{{ $product->id }}')"
                                    wire:loading.attr="disabled"
                                    class="flex items-center hover:cursor-pointer justify-center w-10 h-10 bg-white rounded-full shadow-lg text-indigo-600 hover:bg-indigo-600 hover:text-white transition-colors"
                                >
                                    <x-icon name="plus" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 px-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-sm font-semibold text-zinc-900">
                                        <a href="{{ route('shop.catalog', $product->slug) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-xs text-zinc-500 line-clamp-2">{{ $product->description }}</p>
                                </div>
                                <p class="text-sm font-bold text-zinc-900 font-mono">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </p>
                            </div>
                            <div class="group relative bg-white rounded-2xl p-3 ...">
                                <div class="absolute top-3 left-3 flex flex-col gap-1 z-10">
                                    @foreach($product->tags->take(2) as $tag)
                                        @php
                                            $badges = [
                                                'red' => 'bg-red-100 text-red-700 border-red-200',
                                                'blue' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'green' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                'purple' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'zinc' => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                                            ];
                                            $badgeClass = $badges[$tag->color] ?? $badges['zinc'];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold border shadow-sm backdrop-blur-md bg-opacity-90 {{ $badgeClass }}">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <div
        x-show="cartOpen"
        class="relative z-50"
        style="display: none;"
    >
        <div
            x-show="cartOpen"
            x-transition.opacity.duration.300ms
            class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm"
            @click="cartOpen = false"
        ></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div
                        x-show="cartOpen"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        class="pointer-events-auto w-screen max-w-md"
                    >
                        <div class="flex h-full flex-col bg-white shadow-2xl">

                            <div class="flex items-start justify-between px-4 py-6 sm:px-6 border-b border-zinc-100">
                                <h2 class="text-lg font-medium text-zinc-900" id="slide-over-title">Seu Carrinho</h2>
                                <button type="button" class="relative -m-2 p-2 text-zinc-400 hover:text-zinc-500" @click="cartOpen = false">
                                    <span class="sr-only">Fechar painel</span>
                                    <x-icon name="x-mark" class="h-6 w-6" />
                                </button>
                            </div>

                            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6 bg-zinc-50/50">
                                @if(empty($cart))
                                    <div class="h-full flex flex-col items-center justify-center text-center">
                                        <div class="w-16 h-16 bg-zinc-100 rounded-full flex items-center justify-center mb-4 text-zinc-300">
                                            <x-icon name="shopping-cart" class="w-8 h-8" />
                                        </div>
                                        <p class="text-zinc-500 font-medium">Seu carrinho está vazio.</p>
                                        <button @click="cartOpen = false" class="mt-4 text-indigo-600 font-medium hover:underline text-sm">
                                            Continuar comprando
                                        </button>
                                    </div>
                                @else
                                    <ul role="list" class="-my-6 divide-y divide-zinc-200">
                                        @foreach($cartProducts as $item)
                                            <li class="flex py-6">
                                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-zinc-200 bg-white">
                                                    @if($item->image_path)
                                                        <img src="{{ $item->image_path }}" class="h-full w-full object-cover object-center">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center bg-zinc-50 text-zinc-300">
                                                            <x-icon name="photo" class="w-6 h-6" />
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="ml-4 flex flex-1 flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-zinc-900">
                                                            <h3><a href="#">{{ $item->name }}</a></h3>
                                                            <p class="ml-4 font-mono text-sm">R$ {{ number_format($item->price * $cart[$item->id], 2, ',', '.') }}</p>
                                                        </div>
                                                        <p class="mt-1 text-xs text-zinc-500">{{ $item->category }}</p>
                                                    </div>
                                                    <div class="flex flex-1 items-end justify-between text-sm">
                                                        <div class="flex items-center border border-zinc-200 rounded-lg bg-white">
                                                            <button wire:click="updateQuantity('{{ $item->id }}', {{ $cart[$item->id] - 1 }})" class="px-2 py-1 text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50 rounded-l-lg">-</button>
                                                            <span class="px-2 font-medium text-zinc-900">{{ $cart[$item->id] }}</span>
                                                            <button wire:click="updateQuantity('{{ $item->id }}', {{ $cart[$item->id] + 1 }})" class="px-2 py-1 text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50 rounded-r-lg">+</button>
                                                        </div>

                                                        <div class="flex">
                                                            <button wire:click="removeFromCart('{{ $item->id }}')" type="button" class="font-medium text-red-500 hover:text-red-700 text-xs">Remover</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            @if(!empty($cart))
                                <div class="border-t border-zinc-200 bg-white px-4 py-6 sm:px-6 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                                    <div class="flex justify-between text-base font-medium text-zinc-900 mb-4">
                                        <p>Subtotal</p>
                                        <p>R$ {{ number_format($this->cartTotal, 2, ',', '.') }}</p>
                                    </div>
                                    <p class="mt-0.5 text-xs text-zinc-500 mb-6">Frete e impostos calculados no checkout.</p>
                                    <div class="mt-6">
                                        <a href="#" class="flex items-center justify-center rounded-xl border border-transparent bg-indigo-600 px-6 py-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 transition-all active:scale-[0.98]">
                                            Finalizar Pedido
                                        </a>
                                    </div>
                                    <div class="mt-6 flex justify-center text-center text-sm text-zinc-500">
                                        <p>
                                            ou
                                            <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500" @click="cartOpen = false">
                                                Continuar comprando
                                                <span aria-hidden="true"> &rarr;</span>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
