<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'client_name',
        'client_email',
        'title',
        'status',
        'subtotal',
        'discount',
        'total',
        'valid_until',
        'sent_at',
        'accepted_at',
        'items',
        'notes',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'items' => 'array', // Converte JSON para Array automaticamente
        'total' => 'float',
    ];

    // --- Relacionamentos ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- Acessores de Apresentação (Auxiliares UI) ---

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Rascunho',
            'sent' => 'Enviado',
            'approved' => 'Aprovado',
            'rejected' => 'Recusado',
            default => 'Desconhecido',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'zinc',     // Cinzento neutro
            'sent' => 'blue',      // Azul informativo
            'approved' => 'emerald', // Verde sucesso
            'rejected' => 'red',     // Vermelho erro
            default => 'zinc',
        };
    }
}
