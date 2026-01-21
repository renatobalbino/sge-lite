<?php

namespace App\Livewire\Admin;

use App\Services\EvolutionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

final class WhatsAppConnect extends Component
{
    public ?string $qrCodeBase64 = null;

    public $status = 'disconnected'; // disconnected, connecting, connected

    public $instanceName;

    public function mount(): void
    {
        $user = Auth::user();
        $this->instanceName = $user->whatsapp_instance_id ?? 'loja_'.$user->id;
        $this->status = $user->whatsapp_connected ? 'connected' : 'disconnected';
    }

    public function generateQrCode(EvolutionService $service): void
    {
        $user = Auth::user();

        // 1. Tenta criar a instância se não existir
        if (! $user->whatsapp_instance_id) {
            $response = $service->createInstance($this->instanceName);
            // Salvar token no banco...
            $user->update(['whatsapp_instance_id' => $this->instanceName]);
        }

        // 2. Pede o QR Code
        $connect = $service->connectInstance($this->instanceName, $user->whatsapp_token);

        if (isset($connect['base64'])) {
            $this->qrCodeBase64 = $connect['base64'];
            $this->status = 'connecting';
        }
    }

    // Polling para checar se conectou
    public function checkStatus(EvolutionService $service): void
    {
        if ($this->status === 'connected') {
            return;
        }

        // Aqui você chamaria a API para ver o status da conexão (`/instance/connectionState/{instance}`)
        // Se retornar "open", você atualiza o banco e a view
        // $user->update(['whatsapp_connected' => true]);
        // $this->status = 'connected';
    }

    #[Layout('layouts.sge')]
    public function render(): View
    {
        return view('livewire.whatsapp-connect');
    }
}
