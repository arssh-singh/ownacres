<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Property\PropertyBasicsController;
use App\Models\Property\PropertyBasics;
use App\Models\Property\PropertyPricing;
use App\Models\Property\PropertyLocation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\Property\PropertyMedia;
use App\Models\User;
use App\Services\ImageService;

use App\Services\Search\PropertyIndexService;
use App\Services\Search\QdrantService;


class PropertyController extends Controller
{
    public function __construct(
        private PropertyIndexService $propertyIndexService,
        private ImageService $imageService,
        private QdrantService $qdrantService
    ) {}
    public function index()
    {
        $properties = Property::with(['media', 'coverImage', 'basics'])->where('status', 'published')->latest()->take(4)->get();
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
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'description' => 'required|string',
    //         'price' => 'required|numeric',

    //         'bedrooms' => 'required|integer|min:0',
    //         'bathrooms' => 'required|integer|min:0',
    //         'area' => 'required|integer|min:1',

    //         'location' => 'required|string',
    //         'is_furnished' => 'nullable',

    //     ]);

    //     // Handle checkbox
    //     $validated['is_furnished'] = $request->has('is_furnished');

    //     // Attach logged-in user
    //     $validated['user_id'] = auth()->id();

    //     //Storing image in folder
    //     $path = $request->file('image')->store('prop_images', 'public');
    //     $validated['image'] = $path;


    //     Property::create($validated);

    //     return redirect(route('dashboard.properties'))->with('success', 'Property added!');
    // }
    public function edit(Property $property){
        $this->authorize('update', $property);

        if (! $property->coverImage()->exists()) {
            $property->delete();
            return redirect()->route('dashboard.properties');
        }

        PropertyBasics::firstOrCreate(
            ['property_id' => $property->id],
            [
                'title' => 'No title available',
                'description' => 'No description available',
            ]
        );

        PropertyPricing::firstOrCreate(
            ['property_id' => $property->id],
            [
                'listing_type' => 'sale',
                'price' => 0,
            ]
        );

        PropertyLocation::firstOrCreate(
            ['property_id' => $property->id],
            [
                'city' => 'Unknown',
                'locality' => 'Unknown',
                'postal_code' => '000000',
                'address' => 'Unknown',
                'latitude' => 0,
                'longitude' => 0,
            ]
        );

        return view('auth.dashboard.properties.edit', compact('property'));
    }
    public function update(Request $request, $prop_id){
        if (!$request->boolean('changed.basics') && !$request->boolean('changed.pricing') && !$request->boolean('changed.location') && !$request->boolean('changed.media') && !$request->boolean('changed.cover_image')) {
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
        if ($request->boolean('changed.location')) {
            $this->updateLocation($request, $prop_id);
            array_push($done_a, 'Done Location');
        }
        if ($request->boolean('changed.cover_image')) {
            $this->updateCoverImage($request, $prop_id);
            array_push($done_a, 'Done CoverImage');
        }
        if($request->boolean('changed.media')){
            $this->updateMedia($request, $prop_id);
            array_push($done_a, 'Done media');
        }
        $property = Property::findOrFail($prop_id);

        $this->propertyIndexService->index($property);

        return redirect()->route('dashboard.properties');
    }
    public function delete($prop_id){        
        $prop = Property::where('user_id', auth()->id())->findOrFail($prop_id);
        Storage::disk('public')->deleteDirectory("property_media/{$prop->id}");

        $prop->delete(); // Assuming media records are cascade deleted
        // Delete from Qdrant
        $this->qdrantService->deletePoint($prop->id);
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
    private function updateCoverImage(Request $request, $prop_id)
    {
        $property = Property::findOrFail($prop_id);

        // Convert temp image to WebP and store it
        $image = $this->imageService->processStoredImageToWebp(
            $request->input('cover_image'),
            "property_media/{$prop_id}/main"
        );

        // Delete old cover image if it exists
        if ($property->coverImage) {

            Storage::disk('public')->delete($property->coverImage->file_path);

            $property->coverImage->update([
                'file_path' => $image['path'],
                'mime_type' => $image['mime_type'],
                'file_size' => $image['file_size'],
                'width'     => $image['width'],
                'height'    => $image['height'],
            ]);

        } else {

            $property->media()->create([
                'file_path' => $image['path'],
                'mime_type' => $image['mime_type'],
                'file_size' => $image['file_size'],
                'width'     => $image['width'],
                'height'    => $image['height'],
                'is_cover'  => true,
            ]);

        }
    }
    private function updateMedia(Request $request, $prop_id)
    {
        $keep = [];
        $media = [];

        foreach ($request->input('media', []) as $i => $filepath) {

            $new = false;

            if (str_starts_with($filepath, '[')) {
                $new = true;
                $filepath = json_decode($filepath, true)[0];
            }

            $media[] = [
                'new'       => $new,
                'sort'      => $i,
                'file_path' => $filepath,
            ];
        }

        foreach ($media as $file) {

            if ($file['new']) {

                $image = $this->imageService->processStoredImageToWebp(
                    $file['file_path'],
                    "property_media/{$prop_id}/gallery"
                );

                PropertyMedia::create([
                    'property_id' => $prop_id,
                    'file_path'   => $image['path'],
                    'mime_type'   => $image['mime_type'],
                    'file_size'   => $image['file_size'],
                    'width'       => $image['width'],
                    'height'      => $image['height'],
                    'is_cover'    => false,
                    'sort_order'  => $file['sort'],
                ]);

                $keep[] = $image['path'];

            } else {

                PropertyMedia::where('property_id', $prop_id)
                    ->where('file_path', $file['file_path'])
                    ->update([
                        'sort_order' => $file['sort'],
                    ]);

                $keep[] = $file['file_path'];
            }
        }

        $query = PropertyMedia::where('property_id', $prop_id)
            ->where('is_cover', false);

        if (!empty($keep)) {
            $query->whereNotIn('file_path', $keep);
        }

        $toDelete = $query->get();

        foreach ($toDelete as $media) {
            Storage::disk('public')->delete($media->file_path);
        }

        $query->delete();
    }
    private function updateLocation($request, $prop_id){
        $validator = Validator::make($request->all(), [
            'city' => ['required', 'string', 'max:100'],
            'locality' => ['nullable', 'string', 'max:150'],
            'postal_code' => ['nullable', 'digits:6'],
            'address' => ['required', 'string', 'max:500'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'location')
                ->withInput();
        }

        $validated = $validator->validated();

        $location = PropertyLocation::where('property_id', $prop_id)
            ->whereHas('property', fn ($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $location->update($validated);
    }

    public function updateStatus(Request $request, Property $property)
    {
        $request->validate([
            'status' => 'required|in:draft,archived,published',
        ]);

        $property->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Property status updated to ' . $request->status . '.');
    }
}
