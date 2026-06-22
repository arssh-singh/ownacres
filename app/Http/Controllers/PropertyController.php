<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Property;


class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->take(6)->get();
        return view('index', compact('properties'));
    }
    
    public function marketplace()
    {
        $properties = Property::latest()->paginate(12);
        return view('marketplace', compact('properties'));
    }
    public function prop_details($prop_id)
    {
        $property = Property::findOrFail($prop_id);
        return view('prop_details', compact('property'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric',

            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|integer|min:1',

            'location' => 'required|string',
            'is_furnished' => 'nullable',

        ]);

        // Handle checkbox
        $validated['is_furnished'] = $request->has('is_furnished');

        // Attach logged-in user
        $validated['user_id'] = auth()->id();

        //Storing image in folder
        $path = $request->file('image')->store('prop_images', 'public');
        $validated['image'] = $path;


        Property::create($validated);

        return redirect(route('dashboard.properties'))->with('success', 'Property added!');
    }
    public function get_prop($prop_id){
        $property = Property::where('user_id', auth()->id())->findOrFail($prop_id);
        return view('auth.dashboard.properties.edit', compact('property'));
    }
    public function update(Request $request, $prop_id){
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric',
            'bedrooms'     => 'required|integer|min:0',
            'bathrooms'    => 'required|integer|min:0',
            'area'         => 'required|integer|min:1',
            'location'     => 'required|string',
            'is_furnished' => 'nullable',
        ]);

        $prop = Property::where('user_id', auth()->id())->findOrFail($prop_id);

        if($request->hasFile('image')){
            if($prop->image){
                Storage::disk('public')->delete($prop->image);
            }
            $validated['image'] = $request->file('image')->store('prop_images', 'public'); //merge into $validated
        }

        $prop->update($validated);

        return redirect(route('dashboard.properties'))->with('success', 'Property updated!');
    }
    public function delete($prop_id){        
        $prop = Property::where('user_id', auth()->id())->findOrFail($prop_id);
        if($prop->image){
            Storage::disk('public')->delete($prop->image);
        }
        $prop->delete();
        return redirect(route('dashboard.properties'));
    }
    public function marketplace_search(Request $request){
        $query = Property::query();

        if($request->filled('budget_min') && $request->filled('budget_max')){
            $query->whereBetween('price', [
                $request->budget_min,
                $request->budget_max
            ]);
        }
        $properties = $query->get();
        return response()->json([
            'budget' => $request->all(),
            'html' => view(
                'sections.marketplace.show_properties',
                compact('properties')
            )->render()
        ]);
    }
}
