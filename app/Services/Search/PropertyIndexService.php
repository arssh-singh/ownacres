<?php

namespace App\Services\Search;

use App\Models\Property;

class PropertyIndexService
{
    public function __construct(
        private QdrantService $qdrantService,
        private EmbeddingService $embeddingService,
    ) {}
    public function index(Property $property)
    {
        $property->load([
            'basics',
            'pricing',
            'location',
        ]);

         $text = implode("\n", [
            $property->basics?->title,
            $property->basics?->description,
            $property->location?->city,
            $property->location?->locality,
        ]);

        $vector = $this->embeddingService->embed($text);

        $result = $this->qdrantService->upsert(
            $property->id,
            $vector,
            [
                'title' => $property->basics?->title,
                'description' => $property->basics?->description,
                'city' => $property->location?->city,
                'listing_type' => $property->pricing?->listing_type,
                'price' => $property->pricing?->price,
            ]
        );
        
    }
}