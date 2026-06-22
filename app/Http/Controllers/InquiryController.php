<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Inquiry::create([
            'property_id' => $property->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $property->user_id,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return back()->with('success', 'Inquiry sent successfully!');
    }
    public function index($id = null)
    {
        $inquiries = Inquiry::with('sender')->where('receiver_id', auth()->id())->latest()->get();

        $selectedInquiry = $id
            ? Inquiry::with('sender')->find($id)
            : null;

        return view('auth.dashboard.messages.messages', compact(
            'inquiries',
            'selectedInquiry'
        ));
    }
}