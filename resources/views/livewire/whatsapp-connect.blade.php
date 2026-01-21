<div class="p-6 bg-white rounded-lg shadow" wire:poll.5s="checkStatus">
    <h3 class="text-lg font-bold mb-4">Conexão com WhatsApp</h3>

    @if($status === 'connected')
        <div class="flex items-center text-green-600 bg-green-50 p-4 rounded">
            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div>
                <p class="font-bold">Conectado com Sucesso!</p>
                <p class="text-sm">Seu bot está ativo e respondendo clientes.</p>
            </div>
        </div>
    @else
        @if(!$qrCodeBase64)
            <p class="mb-4 text-gray-600">Clique abaixo para gerar o QR Code e conectar sua loja.</p>
            <button wire:click="generateQrCode" class="bg-indigo-600 text-white px-4 py-2 rounded">
                Gerar QR Code
            </button>
        @else
            <div class="text-center">
                <p class="mb-2 font-medium">Escaneie com seu WhatsApp:</p>
                <img src="{{ $qrCodeBase64 }}" class="mx-auto border-4 border-gray-800 rounded-lg w-64">
                <p class="text-xs text-gray-500 mt-2">Atualizando status...</p>
            </div>
        @endif
    @endif
</div>
