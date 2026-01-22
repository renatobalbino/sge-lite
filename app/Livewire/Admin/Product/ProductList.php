<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

final class ProductList extends Component
{
    use WithPagination;

    public $search = '';

    public bool $hasProducts = false;

    public function mount(): void
    {
        $this->hasProducts = Product::query()->where('user_id', auth()->id())->exists();
    }

    // Filtros adicionais podem vir aqui (ex: $filterStatus = 'all')

    // Reseta a paginação se o usuário buscar algo
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(Product $product): void
    {
        $product->update(['is_active' => ! $product->is_active]);

        // Opcional: Disparar um toast notification aqui
    }

    public function delete(int $id): void
    {
        // Aqui assumo que você usará um confirm no front (AlpineJS)
        $product = Product::find($id);

        if ($product) {
            $product->delete(); // Soft Delete
            session()?->flash('message', 'Produto movido para lixeira.');
        }
    }

    #[Layout('layouts.sge')]
    public function render(): View
    {
        $products = Product::query()
            ->withCount('variants') // Para mostrar "X variações"
            ->withSum('variants', 'stock_quantity') // Soma total do estoque das variações
            ->where('user_id', auth()->id()) // Tenant Scope
            ->when($this->search, function (Builder $query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('sku', 'like', "%{$this->search}%"); // Se tiver SKU no pai
            })
            ->latest()
            ->paginate(15);

        return view('livewire.product.list', ['products' => $products]);
    }
}
