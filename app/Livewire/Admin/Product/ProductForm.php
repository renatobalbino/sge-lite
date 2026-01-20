<?php

namespace App\Livewire\Admin\Product;

use AllowDynamicProperties;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[AllowDynamicProperties]
final class ProductForm extends Component
{
    use WithFileUploads;

    public ?Product $product = null;

    public $name;

    public $description;

    public $price;

    public $has_variants = false;

    public $coverImage;

    public $existingCoverImage;

    public $existingImage;

    public $galleryImages = [];

    public $existingGallery = [];

    public $variants = [];

    protected $rules = [
        'name' => 'required|min:3',
        'price' => 'required|numeric|min:0',
        'coverImage' => 'nullable|image|max:2048',
        'galleryImages.*' => 'image|max:2048',
        'variants.*.name' => 'required_if:has_variants,true|string',
        'variants.*.price' => 'nullable|numeric',
        'variants.*.stock_quantity' => 'required_if:has_variants,true|integer',
    ];

    public function mount(?int $productId = null): void
    {
        $product = Product::query()
            ->with(['variants', 'images'])
            ->find($productId);
        if ($product) {
            $this->product = $product;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price / 100;
            $this->has_variants = $product->has_variants;
            $this->existingCoverImage = $product->image_path;
            $this->existingGallery = $product->images;

            // Carrega variantes existentes ou inicia vazio
            foreach ($product->variants as $variant) {
                $this->variants[] = [
                    'id' => $variant->id, // Importante para update
                    'name' => $variant->name,
                    'price' => $variant->price ? $variant->price / 100 : null,
                    'stock_quantity' => $variant->stock_quantity,
                ];
            }
        } else {
            $this->variants = [['name' => '', 'price' => 0, 'stock_quantity' => 0]];
        }
    }

    public function removeCover(): void
    {
        // Limpa o upload temporário se houver
        $this->reset('coverImage');

        // Limpa a referência da imagem antiga visualmente
        // (A remoção real do banco acontece no método save() se esta variável estiver null)
        $this->existingCoverImage = null;
    }

    public function removeTempGalleryImage($index): void
    {
        // Remove do array de uploads novos e re-indexa o array
        array_splice($this->galleryImages, $index, 1);
    }

    public function removeGalleryImage($id): void
    {
        // Remove imagem já salva no banco (Ação imediata)
        $image = ProductImage::find($id);

        if ($image && $image->product_id === $this->product->id) {
            // Apaga arquivo físico
            Storage::disk('public')->delete($image->image_path);
            // Apaga registro
            $image->delete();

            // Atualiza a collection visualmente para sumir da tela
            $this->existingGallery = $this->existingGallery->reject(fn ($img) => $img->id === $id);
        }
    }

    // Adiciona nova linha na tabela de variações
    public function addVariant(): void
    {
        $this->variants[] = ['name' => '', 'price' => '', 'stock_quantity' => 0];
    }

    // Remove linha específica
    public function removeVariant($index): void
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants); // Reindexa o array
    }

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            $coverPath = $this->existingCoverImage;

            if ($this->coverImage) {
                if ($this->existingCoverImage) {
                    Storage::disk('public')->delete($this->existingCoverImage);
                }
                $coverPath = $this->coverImage->store('products', 'public');
            }

            // 1. Cria o Produto Pai
            $payload = [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'price' => (int) ($this->price * 100),
                'has_variants' => $this->has_variants,
                'image_path' => $coverPath,
            ];

            if ($this->product) {
                $this->product->update($payload);
                $product = $this->product;
            } else {
                $product = Product::create($payload + ['is_active' => true]);
            }

            if (! empty($this->galleryImages)) {
                foreach ($this->galleryImages as $img) {
                    $path = $img->store('products/gallery', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                    ]);
                }
            }

            if ($this->has_variants) {
                $currentVariantIds = [];
                foreach ($this->variants as $variant) {
                    $variantData = [
                        'name' => $variant['name'],
                        'price' => $variant['price'] !== '' ? (int) ($variant['price'] * 100) : null,
                        'stock_quantity' => $variant['stock_quantity'],
                    ];

                    if (isset($variant['id'])) {
                        $product->variants()->where('id', $variant['id'])->update($variantData);
                        $currentVariantIds[] = $variant['id'];
                    } else {
                        $newVariant = $product->variants()->create($variantData);
                        $currentVariantIds[] = $newVariant->id;
                    }
                }
                // Remove variantes que foram deletadas do form
                $product->variants()->whereNotIn('id', $currentVariantIds)->delete();
            }
        });

        session()?->flash('message', 'Produto cadastrado com sucesso!');
        $this->redirectRoute('admin.products.index');
    }

    #[Layout('layouts.sge')]
    public function render(): View
    {
        return view('livewire.product.form');
    }
}
