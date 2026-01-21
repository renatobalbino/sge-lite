<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\User;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function handle(Request $request): ?string
    {
        // 1. Validar e extrair dados do Webhook da Evolution API
        $data = $request->all();
        $event = $data['event'] ?? null;

        if ($event !== 'messages.upsert') {
            return response()->json(['status' => 'ignored']);
        }

        $msg = $data['data']['message'];
        $remoteJid = $data['data']['key']['remoteJid']; // Quem mandou
        $text = $msg['conversation'] ?? $msg['extendedTextMessage']['text'] ?? '';
        $instanceName = $data['instance']; // Identifica qual LOJA (Tenant) está recebendo

        // 2. Achar a Loja (Tenant) baseada na instância
        $tenant = User::where('whatsapp_instance_name', $instanceName)->first();
        if (! $tenant) {
            return null;
        }

        // 3. Achar ou Criar a Sessão do Cliente
        $session = ChatSession::firstOrCreate(
            ['remote_jid' => $remoteJid, 'tenant_id' => $tenant->id],
            ['stage' => 'WELCOME', 'last_interaction_at' => now()]
        );

        // 4. Máquina de Estados (Lógica do Bot)
        $bot = new BotLogic($tenant, $session, $text);
        $bot->process();

        return response()->json(['status' => 'success']);
    }
}
