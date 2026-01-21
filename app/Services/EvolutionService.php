<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class EvolutionService
{
    protected $baseUrl;

    protected $globalKey;

    public function __construct()
    {
        $this->baseUrl = config('services.evolution.url', 'http://localhost:8080');
        $this->globalKey = config('services.evolution.key', 'sua_chave_secreta_global_aqui');
    }

    // Cria uma nova instância para um lojista
    public function createInstance($instanceName)
    {
        return Http::withHeader('apikey', $this->globalKey)
            ->post("{$this->baseUrl}/instance/create", [
                'instanceName' => $instanceName,
                'token' => \Illuminate\Support\Str::random(32),
                'qrcode' => true,
            ])->json();
    }

    // Conecta/Busca QR Code
    public function connectInstance($instanceName, $token)
    {
        return Http::withHeader('apikey', $this->globalKey)
            ->get("{$this->baseUrl}/instance/connect/{$instanceName}");
    }

    // Envia Mensagem de Texto
    public function sendText($instanceName, $phone, $text, $token)
    {
        // Nota: O token aqui é o da instância, não o global
        return Http::withHeader('apikey', $this->globalKey) // Na V2 algumas rotas usam global, cheque a doc
            ->post("{$this->baseUrl}/message/sendText/{$instanceName}", [
                'number' => $phone,
                'text' => $text,
                'options' => ['delay' => 1200], // Simula digitação (Humanizado)
            ]);
    }
}
