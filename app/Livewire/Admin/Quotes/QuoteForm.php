<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\Quote;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

final class QuoteForm extends Component
{
    public ?Quote $quote = null;

    // Campos do Cabeçalho
    public $client_name = '';

    public $client_email = '';

    public $title = '';

    public $date;

    public $valid_until;

    // Itens do Orçamento (Array dinâmico)
    public $items = [];

    // Totais (Calculados)
    public $subtotal = 0;

    public $discount = 0;

    public $total = 0;

    public function mount(?Quote $quote = null): void
    {
        // Se for edição, carrega os dados. Se novo, inicia vazio.
        if ($quote && $quote->exists) {
            $this->quote = $quote;
            $this->client_name = $quote->client_name;
            $this->client_email = $quote->client_email;
            $this->title = $quote->title;
            $this->items = $quote->items ?? [];
            $this->discount = $quote->discount;
            // Datas...
        } else {
            // Inicia com um item vazio para não ficar em branco
            $this->addItem();
            $this->date = now()->format('Y-m-d');
            $this->valid_until = now()->addDays(15)->format('Y-m-d');
        }

        $this->calculateTotals();
    }

    public function addItem()
    {
        $this->items[] = [
            'id' => Str::uuid()->toString(), // Para o Livewire rastrear o DOM
            'description' => '',
            'quantity' => 1,
            'price' => 0,
            'total' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindexar array
        $this->calculateTotals();
    }

    // Hook do Livewire: Disparado sempre que qualquer campo dentro de "items" muda
    public function updatedItems()
    {
        // Recalcula o total da linha
        foreach ($this->items as &$item) {
            $item['quantity'] = (float) ($item['quantity'] ?? 0);
            $item['price'] = (float) ($item['price'] ?? 0);
            $item['total'] = $item['quantity'] * $item['price'];
        }

        $this->calculateTotals();
    }

    // Disparado ao alterar o desconto
    public function updatedDiscount()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->items)->sum('total');
        $this->total = max(0, $this->subtotal - (float) $this->discount);
    }

    public function save()
    {
        $this->validate([
            'client_name' => 'required|min:3',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Cria ou Atualiza
        $data = [
            'client_name' => $this->client_name,
            'client_email' => $this->client_email,
            'title' => $this->title ?: 'Orçamento sem título',
            'items' => $this->items, // O Cast 'array' no model resolve o JSON
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'total' => $this->total,
            'valid_until' => $this->valid_until,
        ];

        if ($this->quote && $this->quote->exists) {
            $this->quote->update($data);
            $message = 'Orçamento atualizado!';
        } else {
            // Tenant ID (assumindo user logado)
            $data['user_id'] = auth()->id();
            $this->quote = Quote::create($data);
            $message = 'Orçamento criado com sucesso!';
        }

        session()->flash('status', $message);

        // Redireciona para a lista ou mantém aqui
        return redirect()->route('admin.quotes.index');
    }

    #[Layout('layouts.sge')]
    public function render(): View
    {
        return view('livewire.quotes.form', [
            'items' => $this->items,
        ]);
    }
}
