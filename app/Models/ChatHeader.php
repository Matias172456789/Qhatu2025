<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHeader extends Model
{
    protected $table = 'chat_header';

    protected $fillable = [
        'user_id',
        'estado',
    ];

    public function chatDetalle()
    {
        return $this->hasMany(ChatDetalle::class, 'chat_header_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
