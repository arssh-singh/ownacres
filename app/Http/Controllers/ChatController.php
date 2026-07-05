<?php

namespace App\Http\Controllers;

use App\Models\Chat\ChatConversation;
use App\Models\Chat\ChatMessage;
use Illuminate\Http\Request;
use App\Models\Property;

class ChatController extends Controller
{
    /**
     * Show chat page
     */
    public function index()
    {
        $conversations = ChatConversation::with(['buyer', 'seller'])
                            ->where(function ($query) {
                                $query->where('buyer_id', auth()->id())
                                    ->orWhere('seller_id', auth()->id());
                            })
                            ->latest()
                            ->get();

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

    /*
        Starting a New Conversation
    */
    public function start(Request $request, $prop_id){
        $property = Property::findOrFail($prop_id);

        // Find existing conversation or create a new one
        $conversation = ChatConversation::firstOrCreate(
            [
                'property_id' => $property->id,
                'buyer_id'    => auth()->id(),
                'seller_id'   => $property->user_id,
            ]
        );
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);
        ChatMessage::create([
            'chat_conversation_id' => $conversation->id,
            'sender_id'            => auth()->id(),
            'message'              => $validated['message'],
            'is_read'              => false,
        ]);

        return redirect()->route('dashboard.chat');
    }
}