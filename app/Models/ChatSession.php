<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    //
    protected $fillable = [
        'remote_jid',
        'tenant_id',
        'stage',
        'last_interaction_at',
        'user_id',
        'current_stage',
        'last_message_at',
    ];
}
