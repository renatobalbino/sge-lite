<div class="min-h-screen bg-zinc-50 py-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">

            <section class="lg:col-span-7">

                <div class="bg-white border border-zinc-200 rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-medium text-zinc-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">1</span>
                        Dados de Contato
                    </h2>

                    <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700">Email</label>
                            <input wire:model.blur="email" type="email" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700">Nome Completo</label>
                            <input wire:model="name" type="text" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700">Telefone / WhatsApp</label>
                            <input wire:model="phone" type="text" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-zinc-200 rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-medium text-zinc-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">2</span>
                        Endereço de Entrega
                    </h2>

                    <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-6 sm:gap-x-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700">CEP</label>
                            <input wire:model.blur="zip" type="text" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        </div>
                        <div class="sm:col-span-4">
                            <label class="block text-sm font-medium text-zinc-700">Endereço</label>
                            <input wire:model="address" type="text" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm font-medium text-zinc-700">Cidade</label>
                            <input wire:model="city" type="text" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-sm font-medium text-zinc-700">Estado</label>
                            <select wire:model="state" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                <option value="">Selecione...</option>
                                <option value="SP">São Paulo</option>
                                <option value="MG">Minas Gerais</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-zinc-200 rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-medium text-zinc-900 mb-4 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">3</span>
                        Pagamento
                    </h2>

                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div
                            wire:click="$set('paymentMethod', 'credit_card')"
                            class="cursor-pointer border rounded-lg p-4 flex flex-col items-center justify-center gap-2 transition-all {{ $paymentMethod === 'credit_card' ? 'border-indigo-600 bg-indigo-50 ring-1 ring-indigo-600' : 'border-zinc-200 hover:border-zinc-300 hover:bg-zinc-50' }}"
                        >
                            <x-icon name="credit-card" class="w-6 h-6 {{ $paymentMethod === 'credit_card' ? 'text-indigo-600' : 'text-zinc-400' }}" />
                            <span class="text-xs font-medium {{ $paymentMethod === 'credit_card' ? 'text-indigo-900' : 'text-zinc-600' }}">Cartão</span>
                        </div>

                        <div
                            wire:click="$set('paymentMethod', 'pix')"
                            class="cursor-pointer border rounded-lg p-4 flex flex-col items-center justify-center gap-2 transition-all {{ $paymentMethod === 'pix' ? 'border-emerald-600 bg-emerald-50 ring-1 ring-emerald-600' : 'border-zinc-200 hover:border-zinc-300 hover:bg-zinc-50' }}"
                        >
                            <x-icon name="qr-code" class="w-6 h-6 {{ $paymentMethod === 'pix' ? 'text-emerald-600' : 'text-zinc-400' }}" />
                            <span class="text-xs font-medium {{ $paymentMethod === 'pix' ? 'text-emerald-900' : 'text-zinc-600' }}">Pix</span>
                        </div>

                        <div
                            wire:click="$set('paymentMethod', 'boleto')"
                            class="cursor-pointer border rounded-lg p-4 flex flex-col items-center justify-center gap-2 transition-all {{ $paymentMethod === 'boleto' ? 'border-zinc-900 bg-zinc-100 ring-1 ring-zinc-900' : 'border-zinc-200 hover:border-zinc-300 hover:bg-zinc-50' }}"
                        >
                            <x-icon name="document-text" class="w-6 h-6 {{ $paymentMethod === 'boleto' ? 'text-zinc-900' : 'text-zinc-400' }}" />
                            <span class="text-xs font-medium {{ $paymentMethod === 'boleto' ? 'text-zinc-900' : 'text-zinc-600' }}">Boleto</span>
                        </div>
                    </div>

                    @if($paymentMethod === 'credit_card')
                        <div class="space-y-4 animate-fade-in-down">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700">Número do Cartão</label>
                                <div class="relative mt-1">
                                    <input wire:model="cardNumber" type="text" placeholder="0000 0000 0000 0000" class="block w-full rounded-lg border-zinc-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-icon name="lock-closed" class="h-4 w-4 text-zinc-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700">Validade</label>
                                    <input wire:model="cardExpiry" type="text" placeholder="MM/AA" class="mt-1 block w-full rounded-lg border-zinc-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700">CVC</label>
                                    <input wire:model="cardCvc" type="text" placeholder="123" class="mt-1 block w-full rounded-lg border-zinc-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                </div>
                            </div>
                            <div class="mt-2 text-xs text-zinc-500 flex items-center gap-1">
                                <x-icon name="shield-check" class="w-4 h-4 text-green-600"/>
                                Pagamento processado de forma segura e criptografada.
                            </div>
                        </div>
                    @elseif($paymentMethod === 'pix')
                        <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4 text-center">
                            <p class="text-sm text-emerald-800 font-medium mb-2">O código Pix será gerado na próxima tela.</p>
                            <p class="text-xs text-emerald-600">Aprovação imediata. Desconto de 5% aplicado automaticamente.</p>
                        </div>
                    @endif
                </div>

            </section>

            <section class="lg:col-span-5 mt-8 lg:mt-0">
                <div class="sticky top-8">
                    <div class="bg-white border border-zinc-200 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 bg-zinc-50 border-b border-zinc-200">
                            <h3 class="text-lg font-bold text-zinc-900">Resumo do Pedido</h3>
                        </div>

                        <div class="p-6 max-h-80 overflow-y-auto space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex gap-4">
                                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-zinc-200 bg-white">
                                        @if($item['image'])
                                            <img src="{{ $item['image'] }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-zinc-100">
                                                <x-icon name="photo" class="w-6 h-6 text-zinc-300"/>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-1 flex-col">
                                        <div class="flex justify-between text-base font-medium text-zinc-900">
                                            <h3 class="line-clamp-1 text-sm">{{ $item['name'] }}</h3>
                                            <p class="ml-4 text-sm font-mono">R$ {{ number_format($item['total'], 2, ',', '.') }}</p>
                                        </div>
                                        <p class="mt-1 text-xs text-zinc-500">Qtd: {{ $item['qty'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-6 bg-zinc-50 border-t border-zinc-200 space-y-3">
                            <div class="flex justify-between text-sm text-zinc-600">
                                <p>Subtotal</p>
                                <p>R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between text-sm text-zinc-600">
                                <p>Frete</p>
                                <p>R$ {{ number_format($shipping, 2, ',', '.') }}</p>
                            </div>

                            <div class="pt-4 flex justify-between items-center border-t border-zinc-200">
                                <p class="text-base font-bold text-zinc-900">Total</p>
                                <p class="text-2xl font-bold text-zinc-900">R$ {{ number_format($total, 2, ',', '.') }}</p>
                            </div>

                            <button
                                wire:click="processOrder"
                                wire:loading.attr="disabled"
                                class="w-full mt-6 bg-indigo-600 border border-transparent rounded-xl py-4 px-4 text-base font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all active:scale-[0.99]"
                            >
                                <span wire:loading.remove>Confirmar Pagamento</span>
                                <span wire:loading class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processando...
                                </span>
                            </button>

                            <div class="mt-4 flex justify-center gap-4 grayscale opacity-50">
                                <div class="h-6 w-10 bg-zinc-200 rounded"></div>
                                <div class="h-6 w-10 bg-zinc-200 rounded"></div>
                                <div class="h-6 w-10 bg-zinc-200 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
