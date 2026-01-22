<x-ui.page>
    <x-slot:header>
        <x-ui.page-header
            title="Meus Orçamentos"
            description="Gerencie as propostas enviadas aos seus clientes"
        >
            <x-slot:actions>
                <x-ui.button variant="secondary" icon="arrow-left" href="{{ url()->previous() }}">Voltar</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>
    </x-slot:header>

    <x-slot:body>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <x-ui.card class="h-full">
                    @livewire('quotes.table')
                </x-ui.card>
            </div>

            <div>
                <x-ui.card title="Resumo do Mês">
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Em aberto</span>
                            <span class="font-medium">R$ 12.500,00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Aprovados</span>
                            <span class="font-medium text-green-600">R$ 45.200,00</span>
                        </div>
                    </div>

                    <x-slot:footer>
                        <x-ui.button variant="ghost" size="sm" class="w-full">
                            Ver Relatório Completo
                        </x-ui.button>
                    </x-slot:footer>
                </x-ui.card>
            </div>
        </div>
    </x-slot:body>
</x-ui.page>
