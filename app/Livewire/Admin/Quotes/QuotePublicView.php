<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\Quote;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class QuotePublicView extends Component
{
    public Quote $quote;
    public $clientNote = ''; // Campo opcional para o cliente deixar um recado

    public function mount(Quote $quote): void
    {
        $this->quote = $quote;
    }

    public function approve(): void
    {
        if ($this->quote->status !== 'sent' && $this->quote->status !== 'draft') {
            return;
        }

        $this->quote->update([
            'status' => 'approved',
            'accepted_at' => now(),
            // Numa V2, salvaria $this->clientNote aqui
        ]);

        // Aqui dispararia uma notificação por email para o dono do SaaS
        // Notification::send($this->quote->user, new QuoteApproved($this->quote));

        session()->flash('success', 'Obrigado! O orçamento foi aprovado com sucesso.');
    }

    public function reject(): void
    {
        if ($this->quote->status !== 'sent' && $this->quote->status !== 'draft') {
            return;
        }

        $this->quote->update([
            'status' => 'rejected',
        ]);

        session()->flash('info', 'Orçamento recusado. O prestador será notificado.');
    }

    #[Layout('layouts.quote')]
    public function render(): View
    {
        return view('livewire.quotes.public');
    }
}
