<?php

namespace App\Http\Controllers;

use App\Models\Chat\ChatConversation;
use App\Models\Chat\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Show chat page
     */
    public function index()
    {
        $conversations = ChatConversation::with('buyer')->get();

        $selected = $conversations->first();

        $messages = collect();

        if ($selected) {
            $messages = ChatMessage::with('sender')
                ->where('chat_conversation_id', $selected->id)
                ->orderBy('created_at')
                ->get();
        }

        return view('auth.dashboard.messages.messages', [
            'conversations' => $conversations,
            'conversation' => $selected,
            'messages' => $messages,
        ]);
    }

    /**
     * Load a conversation (AJAX)
     */
    public function conversation(ChatConversation $conversation)
    {
        $messages = ChatMessage::with('sender')
            ->where('chat_conversation_id', $conversation->id)
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'html' => view(
                'auth.dashboard.messages.messagebox',
                compact('conversation', 'messages')
            )->render()
        ]);
    }

    /**
     * Send a message
     */
    public function send(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:chat_conversations,id'],
            'message' => ['required', 'string'],
        ]);

        ChatMessage::create([
            'chat_conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}