<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\User;
use App\Services\EvolutionService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request, EvolutionService $evoService)
    {
        $payload = $request->all();

        // Verifica se é uma mensagem de texto recebida
        if (($payload['type'] ?? '') !== 'message') {
            return response()->json(['status' => 'ignored']);
        }

        $data = $payload['data'];
        $instanceName = $payload['instance'];
        $remoteJid = $data['key']['remoteJid'];
        $messageText = $data['message']['conversation'] ?? $data['message']['extendedTextMessage']['text'] ?? null;

        if (! $messageText || $data['key']['fromMe']) {
            return;
        } // Ignora mensagens enviadas pelo próprio bot

        // 1. Identifica a Loja
        $tenant = User::where('whatsapp_instance_id', $instanceName)->first();
        if (! $tenant) {
            return;
        }

        // 2. Recupera ou Cria Sessão
        $session = ChatSession::firstOrCreate(
            ['user_id' => $tenant->id, 'remote_jid' => $remoteJid],
            ['current_stage' => 'WELCOME', 'last_message_at' => now()]
        );

        // 3. Lógica Simplificada do Bot
        $response = $this->processBotLogic($session, $messageText, $tenant);

        // 4. Envia Resposta
        if ($response) {
            $evoService->sendText($instanceName, $remoteJid, $response, $tenant->whatsapp_token);
        }

        return response()->json(['status' => 'processed']);
    }

    private function processBotLogic($session, $text, $tenant)
    {
        // === MÁQUINA DE ESTADOS ===

        // Comando global de reinício
        if (strtolower($text) == 'oi' || strtolower($text) == 'menu') {
            $session->update(['current_stage' => 'MENU']);

            return "Olá! Bem-vindo à *{$tenant->name}* 🚀\n\nEscolha uma opção:\n1️⃣ Ver Catálogo Digital\n2️⃣ Meus Pedidos\n3️⃣ Falar com Humano";
        }

        switch ($session->current_stage) {
            case 'WELCOME':
            case 'MENU':
                if ($text == '1') {
                    $link = route('catalog.index', $tenant->slug);

                    return "Acesse nossa loja completa aqui para ver fotos e fazer seu pedido:\n\n👉 {$link}";
                }
                if ($text == '2') {
                    return 'Para consultar status, informe o número do seu pedido (Ex: #1020).';
                }
                if ($text == '3') {
                    $session->update(['current_stage' => 'HUMAN']);

                    return 'Ok! Um atendente irá falar com você em breve.';
                }

                return 'Opção inválida. Digite 1, 2 ou 3.';

            case 'HUMAN':
                // Não responde nada, deixa o humano assumir
                return null;
        }

        return "Olá! Digite 'Menu' para ver as opções.";
    }
}
