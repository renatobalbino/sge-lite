<x-ui.page>
    <x-slot:header>
        <x-ui.page-header
            title="Meus Produtos"
            description="Gerencie seus produtos aqui"
        >
            <x-slot:actions>
                <x-ui.button variant="secondary" wire:click="save">Salvar Rascunho</x-ui.button>
                <x-ui.button variant="primary" wire:click="save">Finalizar e Enviar</x-ui.button>
                <x-ui.button variant="secondary" icon="arrow-left" href="{{ url()->previous() }}">Voltar</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>
    </x-slot:header>

    <x-slot:body>

        <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-8">
            <div class="w-full md:w-1/2">
                <div class="w-12 h-12 bg-zinc-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="text-sm text-zinc-500">
                    <p class="font-bold text-zinc-900">{{ auth()->user()->name ?? 'Sua Empresa' }}</p>
                    <p>contato@suaempresa.com</p>
                </div>
            </div>

            <div class="w-full md:w-1/2 text-right space-y-2">
                <input
                    wire:model="title"
                    type="text"
                    placeholder="Título do Orçamento (Ex: Desenvolvimento Web)"
                    class="w-full text-right text-xl font-bold border-0 border-b border-transparent hover:border-zinc-200 focus:border-indigo-500 focus:ring-0 placeholder-zinc-300 p-0"
                >
                <div class="flex justify-end items-center gap-2 text-sm">
                    <span class="text-zinc-500">Data:</span>
                    <input wire:model="date" type="date" class="border-0 p-0 text-right text-zinc-900 focus:ring-0 w-32 cursor-pointer">
                </div>
                <div class="flex justify-end items-center gap-2 text-sm">
                    <span class="text-zinc-500">Válido até:</span>
                    <input wire:model="valid_until" type="date" class="border-0 p-0 text-right text-zinc-900 focus:ring-0 w-32 cursor-pointer">
                </div>
            </div>
        </div>

        <div class="mb-8 bg-zinc-100 p-6 rounded-lg border border-zinc-100">
            <h3 class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-3">Preparado para</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-ui.input
                        label="Nome do Cliente"
                        labelClass="block text-xs text-zinc-400 mb-1"
                        class="w-full bg-white border border-zinc-200 rounded px-3 py-2 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        wire:model="client_name"
                        placeholder="Ex: Acme Corp"
                    />
                    @error('client_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-ui.input
                        label="Email (Opcional)"
                        labelClass="block text-xs text-zinc-400 mb-1"
                        class="w-full bg-white border border-zinc-200 rounded px-3 py-2 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        wire:model="client_email"
                        placeholder="contato@cliente.com"
                    />
                </div>
            </div>
        </div>

        <div class="mb-12">
            <table class="w-full">
                <thead>
                <tr class="border-b-2 border-zinc-100 text-left">
                    <th class="pb-3 text-xs font-bold text-zinc-400 uppercase tracking-wider w-1/2">Descrição</th>
                    <th class="pb-3 text-xs font-bold text-zinc-400 uppercase tracking-wider text-center w-20">Qtd</th>
                    <th class="pb-3 text-xs font-bold text-zinc-400 uppercase tracking-wider text-right w-32">Preço (R$)</th>
                    <th class="pb-3 text-xs font-bold text-zinc-400 uppercase tracking-wider text-right w-32">Total</th>
                    <th class="w-10"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                @foreach($items as $index => $item)
                    <tr class="group" wire:key="item-{{ $item['id'] }}">
                        <td class="py-4 align-top">
                            <textarea
                                wire:model.live.debounce.500ms="items.{{ $index }}.description"
                                rows="1"
                                placeholder="Descreva o serviço..."
                                class="w-full border-0 p-0 text-sm text-zinc-900 placeholder-zinc-300 focus:ring-0 resize-none bg-transparent"
                            ></textarea>
                        </td>
                        <td class="py-4 align-top">
                            <input
                                wire:model.live="items.{{ $index }}.quantity"
                                type="number"
                                min="1"
                                class="w-full border-0 p-0 text-center text-sm text-zinc-900 focus:ring-0 bg-transparent"
                            >
                        </td>
                        <td class="py-4 align-top">
                            <input
                                wire:model.live.debounce.500ms="items.{{ $index }}.price"
                                type="number"
                                step="0.01"
                                class="w-full border-0 p-0 text-right text-sm text-zinc-900 focus:ring-0 bg-transparent"
                            >
                        </td>
                        <td class="py-4 align-top text-right text-sm font-medium text-zinc-700">
                            {{ number_format($item['total'], 2, ',', '.') }}
                        </td>
                        <td class="py-4 align-top text-right">
                            <button
                                wire:click="removeItem({{ $index }})"
                                class="text-zinc-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all"
                                title="Remover item"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <button
                    wire:click="addItem"
                    class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Adicionar Item
                </button>
                @error('items') <span class="text-xs text-red-500 block mt-2">Adicione pelo menos um item.</span> @enderror
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-end border-t border-zinc-100 pt-8">
            <div class="w-full md:w-1/3 space-y-3">
                <div class="flex justify-between text-sm text-zinc-500">
                    <span>Subtotal</span>
                    <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-sm text-zinc-500">
                    <span>Desconto</span>
                    <div class="flex items-center w-24 border border-zinc-200 rounded bg-white">
                        <span class="pl-2 text-xs text-zinc-400">R$</span>
                        <input
                            wire:model.live.debounce.500ms="discount"
                            type="number"
                            class="w-full border-0 text-right text-xs p-1 focus:ring-0"
                        >
                    </div>
                </div>
                <div class="flex justify-between text-lg font-bold text-zinc-900 border-t border-zinc-100 pt-3">
                    <span>Total</span>
                    <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-12">
            <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Notas ou Termos</label>
            <textarea
                class="w-full border border-zinc-200 rounded-lg p-3 text-sm text-zinc-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 h-24 resize-none"
                placeholder="Ex: Pagamento 50% na entrada..."
            ></textarea>
        </div>
    </x-slot:body>
</x-ui.page>
