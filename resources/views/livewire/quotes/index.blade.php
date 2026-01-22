<x-ui.page>
    <x-slot:header>
        <x-ui.page-header
            title="Meus Orçamentos"
            description="Gerencie as propostas enviadas aos seus clientes"
        >
            <x-slot:actions>
                <x-ui.button variant="primary" icon="plus" href="{{ route('admin.quotes.create') }}">
                    Criar Orçamento
                </x-ui.button>
                <x-ui.button variant="secondary" icon="arrow-left" href="{{ url()->previous() }}">Voltar</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>
    </x-slot:header>

    <x-slot:body>
        <div class="flex flex-col sm:flex-row gap-4 mb-6 justify-between items-center">
            <div class="relative w-full sm:w-72">
                <x-ui.input-icon
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Buscar cliente ou projeto..."
                    class="pl-10 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    <svg class="h-5 w-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </x-ui.input-icon>
            </div>


            <x-ui.select
                wire:model.live="status"
                class="block w-full sm:w-48 rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            >
                <option value="">Todos os Status</option>
                <option value="draft">Rascunho</option>
                <option value="sent">Enviado</option>
                <option value="approved">Aprovado</option>
                <option value="rejected">Rejeitado</option>
            </x-ui.select>
        </div>

        <x-ui.card class="overflow-hidden" padding="p-0">

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200">
                    <thead class="bg-zinc-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Orçamento</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Cliente</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Valor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Ações</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-zinc-200">
                    @forelse ($quotes as $quote)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-zinc-900">#{{ $quote->id }} - {{ $quote->title }}</span>
                                    <span class="text-xs text-zinc-500">{{ $quote->created_at->format('d/m/Y') }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                        {{ substr($quote->client_name, 0, 2) }}
                                    </div>
                                    <div class="text-sm text-zinc-700">{{ $quote->client_name }}</div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono font-medium text-zinc-900">
                                        {{-- Requer Laravel 10+ --}}
                                        {{ Number::currency($quote->total ?? 0, 'BRL') }}
                                    </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $color = $quote->status_color;
                                    $colors = [
                                        'zinc' => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                                        'blue' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'red' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                    $class = $colors[$color] ?? $colors['zinc'];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $class }}">
                                        {{ $quote->status_label }}
                                    </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <x-ui.button variant="ghost" size="sm" href="#">
                                    Editar
                                </x-ui.button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-zinc-100 p-3 rounded-full mb-3">
                                        <svg class="w-8 h-8 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-zinc-900">Nenhum orçamento encontrado</h3>
                                    <p class="mt-1 text-sm text-zinc-500 mb-4">Comece criando uma nova proposta para seu cliente.</p>
                                    <x-ui.button variant="primary" icon="plus">
                                        Criar Orçamento
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($quotes->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 bg-zinc-50">
                    {{ $quotes->links() }}
                </div>
            @endif

        </x-ui.card>
    </x-slot:body>
</x-ui.page>
