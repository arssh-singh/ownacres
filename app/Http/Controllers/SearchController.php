<?php

namespace App\Http\Controllers;
use App\Services\Search\PropertyIndexService;

use Illuminate\Http\Request;
use App\Services\Search\EmbeddingService;
use App\Services\Search\QdrantService;
use App\Models\Property;
class SearchController extends Controller
{
    public function __construct(
        private EmbeddingService $embeddingService,
        private QdrantService $qdrantService,
    ) {}

    public function search(Request $request)
    {
        $query = trim($request->search);

        $words = preg_split('/\s+/', $query);

        $meaningful = collect($words)
            ->contains(fn ($word) => mb_strlen($word) >= 3);

        if (! $meaningful) {
            return response()->json([
                'error' => 'Please enter a more specific search.'
            ], 422);
        }

        $embedding = $this->embeddingService->embed($query);
        $results = $this->qdrantService->search($embedding);
        $ids = collect($results['points'])
            ->filter(fn ($point) => $point['score'] > 0.35)
            ->pluck('id')
            ->all();

        $properties = Property::with([
            'basics',
            'pricing',
            'location'
        ])
        ->whereIn('id', $ids)
        ->get()
        ->sortBy(fn ($property) => array_search($property->id, $ids))
        ->values();

        return response()->json(['html'=>view('sections.marketplace.show_properties', compact('properties'))->render(),
        'Results' => $results,
        ]);
    }
}
