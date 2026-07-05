<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Property\PropertyMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PropertyMediaController extends Controller
{
    public function store(Request $request, Property $property)
    {
        $this->authorize('update', $property);
        $request->validate([
            'mainImage' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240',],
            'gallery' => 'nullable|array|max:10',
            'gallery.*' => 'mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:102400',
        ]);
        $storedFiles = [];
        try{
            DB::transaction(function () use ($request, $property, &$storedFiles) {
                
                // ==========================
                // Cover Image
                // ==========================
                $oldCover = $property->coverImage;
                $cover = $request->file('mainImage');
                $coverPath = $cover->store(
                    "property_media/{$property->id}/main",
                    'public'
                );
                $storedFiles[] = $coverPath;
                PropertyMedia::create([
                    'property_id' => $property->id,
                    'file_path'   => $coverPath,
                    'mime_type'   => $cover->getMimeType(),
                    'file_size'   => $cover->getSize(),
                    'is_cover'    => true,
                    'sort_order'  => 0,
                ]);
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

                        $path = $file->store(
                            "property_media/{$property->id}/gallery",
                            'public'
                        );

                        $storedFiles[] = $path;

                        PropertyMedia::create([
                            'property_id' => $property->id,
                            'file_path'   => $path,
                            'mime_type'   => $file->getMimeType(),
                            'file_size'   => $file->getSize(),
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
