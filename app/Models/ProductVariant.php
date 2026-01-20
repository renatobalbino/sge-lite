<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ProductVariant extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'properties' => 'array', // Transforma o JSON em Array PHP automaticamente
        'stock_quantity' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Lógica inteligente de preço:
     * Retorna o preço da variação se existir, caso contrário retorna o do pai.
     */
    public function getFinalPriceAttribute(): int
    {
        return $this->price ?? $this->product->price;
    }
}
