<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class WhatsAppService
{
    protected string $baseUrl;

    protected string $apiKey;

    public function __construct()
    {
        // Configurações da Evolution API (no .env)
        $this->baseUrl = config('services.whatsapp.url');
        $this->apiKey = config('services.whatsapp.key');
    }

    public function sendMessage($instanceName, $phone, $message)
    {
        return Http::withHeaders([
            'apikey' => $this->apiKey,
        ])->post("{$this->baseUrl}/message/sendText/{$instanceName}", [
            'number' => $phone,
            'text' => $message,
        ]);
    }

    // Método para enviar botões (Melhor UX que digitar números)
    public function sendButtons($instanceName, $phone, $title, $description, array $buttons)
    {
        // Implementação específica da API para botões...
    }
}
