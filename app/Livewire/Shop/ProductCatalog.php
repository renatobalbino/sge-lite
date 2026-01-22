<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

final class ProductCatalog extends Component
{
    use WithPagination;

    public $search = '';

    public $category = 'all';

    public $selectedTag = null;

    // O Carrinho será um array simples [product_id => quantity]
    // Em produção, recomendo usar um Carrinho no Banco ou Redis.
    public $cart = [];

    public function mount()
    {
        $this->cart = session()?->get('cart', []);
    }

    public function toggleTag($tagSlug): void
    {
        // Se clicar na mesma, remove o filtro
        if ($this->selectedTag === $tagSlug) {
            $this->selectedTag = null;
        } else {
            $this->selectedTag = $tagSlug;
        }
        $this->resetPage();
    }

    public function addToCart($productId): void
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]++;
        } else {
            $this->cart[$productId] = 1;
        }

        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart');
    }

    public function removeFromCart($productId): void
    {
        unset($this->cart[$productId]);
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    public function updateQuantity($productId, $qty): void
    {
        if ($qty <= 0) {
            $this->removeFromCart($productId);

            return;
        }

        $this->cart[$productId] = $qty;
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }

    protected function saveCart(): void
    {
        session()->put('cart', $this->cart);
    }

    public function getCartTotalProperty(): int
    {
        if (empty($this->cart)) {
            return 0;
        }

        $ids = array_keys($this->cart);
        $products = Product::whereIn('id', $ids)->get();

        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * ($this->cart[$product->id] ?? 0);
        }

        return $total;
    }

    #[Layout('layouts.shop')]
    public function render(): View
    {
        $query = Product::query()->where('is_active', true);

        // Filtro de Texto
        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        // Filtro de Tags (Relacionamento)
        if ($this->selectedTag) {
            $query->whereHas('tags', function ($q) {
                $q->where('slug', $this->selectedTag);
            });
        }

        $products = $query->paginate(12);

        // Busca os produtos que estão no carrinho para exibir na gaveta
        $cartProducts = [];
        if (! empty($this->cart)) {
            $cartProducts = Product::whereIn('id', array_keys($this->cart))->get();
        }

        return view('livewire.shop.product-catalog', [
            'products' => $products,
            'cartProducts' => $cartProducts,
            'allTags' => Tag::all(),
        ]);
    }
}
