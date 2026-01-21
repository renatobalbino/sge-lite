<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Catálogo de Produtos</h2>

        @if (!empty($products))
        <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Novo Produto
        </a>
        @endif
    </div>

    <div class="w-full">
        <x-ui.input-icon
            wire:model.live.debounce.300ms="search"
            placeholder="Buscar por nome, código..."
        >
            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </x-ui.input-icon>
    </div>

    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Produto
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Preço
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Estoque
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Ações</span>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr wire:key="row-{{ $product->id }}" class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                    <img src="{{ $product->cover_image }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        @if($product->has_variants)
                                            {{ $product->variants_count }} variações cadastradas
                                        @else
                                            Produto Simples
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $product->formatted_price }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                // Se tem variações, usamos a soma do Eager Loading.
                                // Se não, usamos o campo stock do produto (que não criamos no schema inicial,
                                // mas vamos assumir que produto simples tem gestão interna ou usamos uma variaçao default)
                                $stock = $product->has_variants ? $product->variants_sum_stock_quantity : 'N/A';
                            @endphp

                            @if($stock === 0 || $stock === '0')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Esgotado
                                </span>
                            @elseif($stock === 'N/A')
                                <span class="text-xs text-gray-400">-</span>
                            @else
                                <span class="text-sm text-gray-600">{{ $stock }} unid.</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <button
                                wire:click="toggleStatus({{ $product->id }})"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $product->is_active ? 'bg-indigo-600' : 'bg-gray-200' }}"
                            >
                                <span
                                    aria-hidden="true"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $product->is_active ? 'translate-x-5' : 'translate-x-0' }}"
                                ></span>
                            </button>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.products.show', [$product->id]) }}" class="text-slate-600 hover:text-indigo-900">Ver</a>
                                <a href="{{ route('admin.products.create', $product) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>

                                <button
                                    type="button"
                                    x-data
                                    @click="if(confirm('Tem certeza que deseja excluir este produto?')) $wire.delete({{ $product->id }})"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-lg font-medium text-gray-900">Nenhum produto encontrado</p>
                                <p class="text-sm text-gray-500">Comece adicionando itens ao seu catálogo.</p>
{{--                                <a href="{{ route('admin.products.create') }}" class="mt-4 text-indigo-600 hover:text-indigo-500 font-medium">--}}
{{--                                    Criar primeiro produto &rarr;--}}
{{--                                </a>--}}

                                <a href="{{ route('admin.products.create') }}" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Novo Produto
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $products->links() }}
        </div>
    </div>
</div>
