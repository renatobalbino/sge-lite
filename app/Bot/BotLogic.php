<?php

use App\Models\Order;

final class BotLogic
{
    public function process()
    {
        // Se o cliente mandou "Sair" ou "Reset", reinicia
        if (strtolower($this->text) === 'sair') {
            $this->session->update(['stage' => 'WELCOME']);
            $this->reply("Atendimento finalizado. Digite 'Oi' para começar de novo.");

            return;
        }

        switch ($this->session->stage) {
            case 'WELCOME':
                $this->handleWelcome();
                break;

            case 'MAIN_MENU':
                $this->handleMainMenu();
                break;

            case 'ORDER_PENDING':
                // Lógica se ele estiver no meio de um pedido
                break;
        }
    }

    protected function handleWelcome()
    {
        $nomeLoja = $this->tenant->store_name;

        $msg = "Olá! Bem-vindo ao *{$nomeLoja}*! 🤖\n\n";
        $msg .= "Como posso te ajudar hoje?\n";
        $msg .= "1️⃣ Ver Cardápio/Catálogo\n";
        $msg .= "2️⃣ Meus Pedidos\n";
        $msg .= '3️⃣ Falar com Atendente Humano';

        $this->reply($msg);

        // Avança o estado
        $this->session->update(['stage' => 'MAIN_MENU']);
    }

    protected function handleMainMenu(): void
    {
        $input = trim($this->text);

        if ($input === '1') {
            // AQUI É O PULO DO GATO:
            // Não tente vender por texto. Mande o link do seu Web App logado!

            $link = route('catalog.index', ['slug' => $this->tenant->slug]);

            $this->reply("Ótimo! Acesse nosso catálogo digital para ver as fotos e montar seu pedido com facilidade:\n\n👉 {$link}");

            // Opcional: Manter no menu ou esperar
        } elseif ($input === '2') {
            // Consultar pedidos no banco
            $lastOrder = Order::where('remote_jid', $this->session->remote_jid)->latest()->first();
            if ($lastOrder) {
                $this->reply("Seu último pedido (#{$lastOrder->id}) está: *{$lastOrder->status}*");
            } else {
                $this->reply('Você ainda não tem pedidos recentes.');
            }
        } elseif ($input === '3') {
            $this->reply('Entendido. Estou chamando um atendente. Aguarde um momento...');
            // Aqui você poderia notificar o dono da loja via Painel ou Email
            $this->session->update(['stage' => 'HUMAN_SUPPORT']);
        } else {
            $this->reply('Desculpe, não entendi. Digite apenas o número da opção (ex: 1).');
        }
    }

    private function reply($message)
    {
        app(WhatsappService::class)->sendMessage(
            $this->tenant->whatsapp_instance_name,
            $this->session->remote_jid,
            $message
        );
    }
}
