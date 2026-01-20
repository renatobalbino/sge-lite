<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ProductShow extends Component
{
    public Product $product;

    public function mount(int $productId)
    {
        $this->product = Product::query()
            ->with(['variants', 'images'])
            ->findOrFail($productId);
    }

    #[Layout('layouts.sge')]
    public function render(): View
    {
        // Simulando dados para o gráfico (No futuro, virá de $product->orderItems()...)
        $chartData = [
            'dates' => ['01/01', '05/01', '10/01', '15/01', '20/01', 'Today'],
            'sales' => [12, 19, 3, 5, 2, 15],
            'revenue' => [1200, 1900, 300, 500, 200, 1500],
        ];

        return view('livewire.product.show', [
            'chartData' => $chartData,
        ]);
    }
}
