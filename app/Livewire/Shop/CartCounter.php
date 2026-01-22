<?php

namespace App\Livewire\Shop;

use Livewire\Attributes\On;
use Livewire\Component;

final class CartCounter extends Component
{
    public $count = 0;

    public function mount(): void
    {
        $this->updateCount();
    }

    #[On('cart-updated')] // Escuta o evento quando alguém clica em "Comprar"
    public function updateCount(): void
    {
        $cart = session()?->get('cart', []);
        $this->count = array_sum($cart);
    }

    public function render(): string
    {
        if ($this->count === 0) {
            return <<<'HTML'
            <div></div>
        HTML;
        }

        return <<<'HTML'
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-indigo-600 rounded-full ring-2 ring-white">
                {{ $count }}
            </span>
        HTML;
    }
}
