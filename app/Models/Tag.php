<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Tag extends Model
{
    use HasUlids;

    protected $fillable = ['name', 'slug', 'color'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
