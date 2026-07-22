<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Property\PropertyMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;

class PropertyMediaController extends Controller
{
    public function store(Request $request, Property $property, ImageService $imageService)
    {
        // checking if the user has right to do this
        $this->authorize('update', $property);

        // validating received media
        $request->validate([
            'mainImage' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240',],
            'gallery' => 'nullable|array|max:10',
            'gallery.*' => 'mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:102400',
        ]);


        $storedFiles = [];
        try{
            DB::transaction(function () use ($request, $property, &$storedFiles, $imageService) {
                
                // ==========================
                // Cover Image
                // ==========================
                
                // getting old cover image incase user returned from next page with back button
                $oldCover = $property->coverImage;
                // getting the uploaded image by user
                $cover = $imageService->processToWebp(
                            $request->file('mainImage'),
                            "property_media/{$property->id}/main"
                        );
                $storedFiles[] = $cover['path'];
                PropertyMedia::create([
                    'property_id' => $property->id,
                    'file_path'   => $cover['path'],
                    'mime_type'   => $cover['mime_type'],
                    'file_size'   => $cover['file_size'],
                    'is_cover'    => true,
                    'sort_order'  => 0,
                ]);
                // deleting the old cover if there was any
                if ($oldCover) {
                    Storage::disk('public')->delete($oldCover->file_path);
                    $oldCover->delete();
                }
                // ==========================
                // Gallery
                // ==========================
                if ($request->hasFile('gallery')) {
                    $sortOrder = 1;

                    foreach ($request->file('gallery') as $file) {

                        $image = $imageService->processToWebp(
                            $file,
                            "property_media/{$property->id}/gallery"
                        );

                        $storedFiles[] = $image['path'];

                        PropertyMedia::create([
                            'property_id' => $property->id,
                            'file_path'   => $image['path'],
                            'mime_type'   => $image['mime_type'],
                            'file_size'   => $image['file_size'],
                            'is_cover'    => false,
                            'sort_order'  => $sortOrder++,
                        ]);
                    }
                }
            });
        } catch(\Throwable $e){
            // delete uploaded files
            foreach($storedFiles as $file){
                Storage::disk('public')->delete($file);
            }
            throw $e;
        }
        return redirect()
                ->route('properties.basics.get', $property)
                ->with('success', 'Media uploaded successfully.');
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('tmp', 'public');

            return response($path, 200);
        }
        if ($request->hasFile('media')){
            if ($request->hasFile('media')) {
                $paths = [];

                foreach ($request->file('media') as $file) {
                    $paths[] = $file->store('tmp', 'public');
                }

                return response()->json($paths);
            }
        }

        return response('No file uploaded', 400);
    }
    public function delete(Request $request)
    {
        Storage::disk('public')->delete($request->getContent());
    }
}
