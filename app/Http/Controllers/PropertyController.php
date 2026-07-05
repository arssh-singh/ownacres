<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Property\PropertyBasicsController;
use App\Models\Property\PropertyBasics;
use App\Models\Property\PropertyPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\Property\PropertyMedia;


class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with(['media', 'coverImage', 'basics'])->latest()->take(4)->get();
        return view('index', compact('properties'));
    }
    public function create(){
        $property = Property::create([
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('properties.media.get', $property);
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
        $property = Property::with(['media', 'coverImage', 'pricing'])
            ->where('user_id', auth()->id())
            ->findOrFail($prop_id);
        return view('auth.dashboard.properties.edit', compact('property'));
    }
    public function update(Request $request, $prop_id){
        if (!$request->boolean('changed.basics') && !$request->boolean('changed.price') && !$request->boolean('changed.media') && !$request->boolean('changed.cover_image')) {
            return response()->json([
                'Done' => 'no changes',
            ]);
        }
        $done_a = [];
        if($request->boolean('changed.basics')){
            $this->updateBasics($request, $prop_id);
            array_push($done_a, 'Done basics');
        }
        if ($request->boolean('changed.pricing')) {
            $this->updatePricing($request, $prop_id);
            array_push($done_a, 'Done Pricing');
        }
        if ($request->boolean('changed.cover_image')) {
            if(!str_starts_with($request->input('cover_image'), 'http')){
                $this->updateCoverImage($request, $prop_id);
                array_push($done_a, 'Done CoverImage');
            }
        }
        if($request->boolean('changed.media')){
            $this->updateMedia($request, $prop_id);
            array_push($done_a, 'Done media');
        }
        return redirect()->route('dashboard.properties');
    }
    public function delete($prop_id){        
        $prop = Property::where('user_id', auth()->id())->findOrFail($prop_id);
        Storage::disk('public')->deleteDirectory("property_media/{$prop->id}");

        $prop->delete(); // Assuming media records are cascade deleted
        return redirect(route('dashboard.properties'));
    }





    private function updateBasics(Request $request, $prop_id) {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $basics = PropertyBasics::where('property_id', $prop_id)
            ->whereHas('property', fn ($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $basics->update($validated);
    }
    private function updatePricing(Request $request, $prop_id){
        $validated = $request->validate([
            'listing_type' => ['required', 'string', 'in:sale,rent'],
            'price'        => ['required', 'numeric', 'min:0'],
        ]);

        $pricing = PropertyPricing::where('property_id', $prop_id)
            ->whereHas('property', fn ($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $pricing->update($validated);
    }
    private function updateCoverImage(Request $request, $prop_id){
        $newFilename = Str::after($request->input('cover_image'), 'tmp/');
        $newPath = "property_media/{$prop_id}/main/{$newFilename}";
        Storage::disk('public')->move($request->input('cover_image'), $newPath);
        $property = Property::findOrFail($prop_id);
        // Delete old file
        if ($property->coverImage) {
            Storage::disk('public')->delete($property->coverImage->file_path);

            $property->coverImage->update([
                'file_path' => $newPath,
            ]);
        }
        else {
            $property->media()->create([
                'file_path' => $newPath,
                'is_cover' => true,
            ]);
        }
    }
    private function updateMedia($request, $prop_id){
        $keep = [];
        $media = [];
        foreach($request->media as $i => $filepath){
            $new = false;
            if(str_starts_with($filepath, '[')){
                $new = true;
                $filepath = json_decode($filepath, true)[0];
            }
            $media[] = [
                'new' => $new,
                'sort' => $i,
                'file_path' => $filepath
                ];
        }
        foreach($media as $file){
            if($file['new']==true){
                $newFilename = Str::after($file['file_path'], 'tmp/');
                $newPath = "property_media/{$prop_id}/gallery/{$newFilename}";

                Storage::disk('public')->move($file['file_path'], $newPath);

                PropertyMedia::create([
                    'property_id' => $prop_id,
                    'file_path'   => $newPath,
                    'is_cover'    => false,
                    'sort_order'  => $file['sort'],
                ]);
                $keep[] = $newPath;
            }
            else{
                PropertyMedia::where('property_id', $prop_id)
                ->where('file_path', $file['file_path'])
                ->update([
                    'sort_order' => $file['sort'],
                ]);
                $keep[] = $file['file_path'];
            }
        }
        $toDelete = PropertyMedia::where('property_id', $prop_id)
                    ->where('is_cover', false)
                    ->whereNotIn('file_path', $keep)
                    ->get();
        foreach ($toDelete as $media) {
            Storage::disk('public')->delete($media->file_path);
        }
        PropertyMedia::where('property_id', $prop_id)
                        ->where('is_cover', false)
                        ->whereNotIn('file_path', $keep)
                        ->delete();
    }
    public function updateStatus(Request $request, Property $property)
    {
        $request->validate([
            'status' => 'required|in:draft,archived,published',
        ]);

        Property::where('id', $property->id)->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Property status updated to ' . $request->status . '.');
    }
}
