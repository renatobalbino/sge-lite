<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\Quote;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

// Certifique-se de criar este Model depois

final class QuoteList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    // Resetar paginação ao buscar
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    // Helper para cores de status (pode ir para o Model depois)
    public function getStatusColor(string $status): string
    {
        return match ($status) {
            'draft' => 'zinc',
            'sent' => 'blue',
            'approved' => 'emerald',
            'rejected' => 'red',
            default => 'zinc',
        };
    }

    // Helper para tradução (pode ir para o Model)
    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'draft' => 'Rascunho',
            'sent' => 'Enviado',
            'approved' => 'Aprovado',
            'rejected' => 'Rejeitado',
            default => 'Desconhecido',
        };
    }

    #[Layout('layouts.sge')]
    public function render(): View
    {
        // Exemplo de Query (ajuste conforme seu Model real)
        // Se ainda não tiver banco, vai retornar vazio e mostrar o Empty State
        $quotes = Quote::query()
            //->where('team_id', Auth::id()) // ou tenant_id
            ->when($this->search, function ($q) {
                $q->where('client_name', 'like', '%'.$this->search.'%')
                    ->orWhere('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.quotes.index', [
            'quotes' => $quotes,
        ]);
    }
}
