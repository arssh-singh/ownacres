<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\WebpEncoder;

class ImageService
{
    /**
     * Compress, convert to WebP and store an uploaded image.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $quality
     * @param int $maxWidth
     * @return array
     */
    public function processToWebp(
        UploadedFile $file,
        string $directory,
        int $quality = 1,
        int $maxWidth = 1920
    ): array {

        // Read uploaded image
        $image = Image::decode($file);

        // Resize while maintaining aspect ratio
        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        // Generate unique filename
        $filename = uniqid('', true) . '.webp';

        // Storage path
        $path = "{$directory}/{$filename}";

        // Encode as WebP
        $encoded = $image->encode(
            new WebpEncoder($quality)
        );

        // Save to storage
        Storage::disk('public')->put($path, (string) $encoded);

        return [
            'path'      => $path,
            'mime_type' => 'image/webp',
            'file_size' => Storage::disk('public')->size($path),
            'width'     => $image->width(),
            'height'    => $image->height(),
        ];
    }
    public function processStoredImageToWebp(
        string $sourcePath,
        string $directory,
        int $quality = 10,
        int $maxWidth = 1920
    ): array {

        // Get absolute path to the stored image
        $fullPath = Storage::disk('public')->path($sourcePath);

        // Decode existing image
        $image = Image::decode(file_get_contents($fullPath));

        // Resize if needed
        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        // Generate unique filename
        $filename = uniqid('', true) . '.webp';
        $path = "{$directory}/{$filename}";

        // Encode as WebP
        $encoded = $image->encode(new WebpEncoder($quality));

        // Save WebP
        Storage::disk('public')->put($path, (string) $encoded);

        // Delete original temp image
        Storage::disk('public')->delete($sourcePath);

        return [
            'path'      => $path,
            'mime_type' => 'image/webp',
            'file_size' => Storage::disk('public')->size($path),
            'width'     => $image->width(),
            'height'    => $image->height(),
        ];
    }
}