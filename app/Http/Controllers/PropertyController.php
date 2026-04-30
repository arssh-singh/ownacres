<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->get();
        return view('properties.index', compact('properties'));
    }
    public function show($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.show', compact('property'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',

            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|integer|min:1',

            'location' => 'required|string',

            'is_furnished' => 'nullable'
        ]);

        // Handle checkbox
        $validated['is_furnished'] = $request->has('is_furnished');

        // Attach logged-in user
        $validated['user_id'] = auth()->id();

        Property::create($validated);

        return redirect(route('dashboard'))->with('success', 'Property added!');
    }
}
