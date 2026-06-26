<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ChatConversation extends Model
{
    protected $fillable = [
        'property_id',
        'buyer_id',
        'seller_id',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_conversation_id');
    }
}