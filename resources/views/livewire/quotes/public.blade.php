<div class="min-h-screen pb-32"> <div class="bg-white border-b border-zinc-200 py-4 px-6 mb-8 text-center shadow-sm">
        <h2 class="text-lg font-bold text-zinc-900 tracking-tight">
            {{ $quote->user->name ?? 'Proposta Comercial' }}
        </h2>
    </div>

    @if (session('success'))
        <div class="max-w-3xl mx-auto mb-6 px-4">
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-3 text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-lg font-bold text-green-800">Proposta Aprovada!</h3>
                <p class="text-green-600">Obrigado pela confiança. Entraremos em contacto em breve para iniciar o serviço.</p>
            </div>
        </div>
    @elseif(session('info'))
        <div class="max-w-3xl mx-auto mb-6 px-4">
            <div class="bg-zinc-100 border border-zinc-200 rounded-xl p-4 text-center text-zinc-600">
                {{ session('info') }}
            </div>
        </div>
    @endif

    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl border border-zinc-200 overflow-hidden mx-4 md:mx-auto">
        <div class="h-1.5 w-full {{ $quote->status === 'approved' ? 'bg-green-500' : ($quote->status === 'rejected' ? 'bg-red-500' : 'bg-indigo-600') }}"></div>

        <div class="p-8 md:p-12">

            <div class="flex flex-col md:flex-row justify-between items-start mb-10 gap-6">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900">{{ $quote->title }}</h1>
                    <p class="text-sm text-zinc-500 mt-1">Orçamento #{{ strtoupper(substr($quote->id, -6)) }}</p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-sm text-zinc-500">Data de emissão</p>
                    <p class="font-medium text-zinc-900">{{ $quote->created_at->format('d/m/Y') }}</p>

                    <p class="text-sm text-zinc-500 mt-2">Válido até</p>
                    <p class="font-medium {{ $quote->valid_until && $quote->valid_until->isPast() ? 'text-red-600' : 'text-zinc-900' }}">
                        {{ $quote->valid_until ? $quote->valid_until->format('d/m/Y') : 'Indeterminado' }}
                    </p>
                </div>
            </div>

            <div class="border-t border-zinc-100 my-8"></div>

            <div class="mb-10">
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider mb-2">Preparado para</p>
                <p class="text-lg font-medium text-zinc-900">{{ $quote->client_name }}</p>
                @if($quote->client_email)
                    <p class="text-zinc-500">{{ $quote->client_email }}</p>
                @endif
            </div>

            <table class="w-full mb-10">
                <thead>
                <tr class="border-b border-zinc-200 text-left">
                    <th class="py-3 text-xs font-bold text-zinc-400 uppercase tracking-wider">Descrição</th>
                    <th class="py-3 text-xs font-bold text-zinc-400 uppercase tracking-wider text-center">Qtd</th>
                    <th class="py-3 text-xs font-bold text-zinc-400 uppercase tracking-wider text-right">Total</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                @foreach($quote->items as $item)
                    <tr>
                        <td class="py-4 text-sm text-zinc-700">
                            {{ $item['description'] }}
                        </td>
                        <td class="py-4 text-sm text-zinc-700 text-center">
                            {{ $item['quantity'] }}
                        </td>
                        <td class="py-4 text-sm font-medium text-zinc-900 text-right">
                            R$ {{ number_format($item['total'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-full md:w-1/2 space-y-3">
                    <div class="flex justify-between text-sm text-zinc-500">
                        <span>Subtotal</span>
                        <span>R$ {{ number_format($quote->subtotal, 2, ',', '.') }}</span>
                    </div>
                    @if($quote->discount > 0)
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Desconto</span>
                            <span>- R$ {{ number_format($quote->discount, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-xl font-bold text-zinc-900 border-t border-zinc-200 pt-4">
                        <span>Total</span>
                        <span>R$ {{ number_format($quote->total, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            @if($quote->notes)
                <div class="mt-12 bg-zinc-50 p-6 rounded-lg text-sm text-zinc-600 border border-zinc-100">
                    <p class="font-bold text-zinc-900 mb-2">Notas e Condições:</p>
                    {!! nl2br(e($quote->notes)) !!}
                </div>
            @endif

        </div>
    </div>

    @if($quote->status === 'draft' || $quote->status === 'sent')
        <div class="fixed bottom-0 inset-x-0 bg-white border-t border-zinc-200 p-4 shadow-lg z-50">
            <div class="max-w-3xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-zinc-500 hidden sm:block">
                    Ao clicar em aprovar, você concorda com os valores informados acima.
                </div>
                <div class="flex w-full sm:w-auto gap-3">
                    <button
                        wire:click="reject"
                        wire:confirm="Tem certeza que deseja recusar esta proposta?"
                        class="flex-1 sm:flex-none px-6 py-3 bg-white border border-red-200 text-red-600 rounded-lg font-medium hover:bg-red-50 transition-colors"
                    >
                        Recusar
                    </button>
                    <button
                        wire:click="approve"
                        class="flex-1 sm:flex-none px-8 py-3 bg-indigo-600 text-white rounded-lg font-bold shadow-md hover:bg-indigo-700 transform active:scale-95 transition-all flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Aprovar Orçamento
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
