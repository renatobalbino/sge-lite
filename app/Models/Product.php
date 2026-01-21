<?php

namespace App\Models;

use AllowDynamicProperties;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[AllowDynamicProperties]
final class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'has_variants' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Relacionamento com as Variações
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Acessor para formatar preço (Ex: $product->formatted_price)
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'R$ '. number_format($this->price / 100, 2, ',', '.')
        );
    }

    public function getCoverImageAttribute(): string
    {
        return Storage::url($this->image_path);
    }
}
