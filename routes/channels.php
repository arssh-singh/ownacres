<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat\ChatConversation;
use Illuminate\Support\Facades\Log;


Broadcast::channel('conversation.{conversation}', function ($user, ChatConversation $conversation) {

    Log::info('Channel auth', [
        'user' => $user->id,
        'buyer' => $conversation->buyer_id,
        'seller' => $conversation->seller_id,
    ]);

    return $conversation->buyer_id === $user->id
        || $conversation->seller_id === $user->id;
});