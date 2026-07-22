<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class MarketplaceController extends Controller
{
    public function marketplace()
    {
        $properties = Property::with(['media', 'coverImage', 'basics'])
        ->where('status', 'published')
        ->latest()
        ->paginate(12);
        return view('marketplace', compact('properties'));
    }
    public function marketplace_search(Request $request){
        // send query
        $query = $request->search;
            $system_prompt = <<<PROMPT
            You are OwnAcres AI Search.

            Your task is to convert a natural language property search into JSON filters for Algolia.

            Return ONLY a valid JSON object.
            Do not include markdown, explanations, or extra text.

            Available fields:

            {
            "search": string,
            "location": string|null,
            "bedrooms": integer|null,
            "bathrooms": integer|null,
            "listing_type": "sale"|"rent"|null,
            "min_price": integer|null,
            "max_price": integer|null
            }

            Field descriptions:

            - search
            - Contains the important searchable keywords.
            - Include property type, furnishing, amenities, luxury, office, villa, apartment, plot, commercial, swimming pool, garden, corner, etc.
            - Exclude location, bedroom count, bathroom count, listing type, and price from this field.
            - Remove conversational words such as:
                best, good, nice, top, latest, available, nearby, please, show me, find me, I want, looking for.

            - location
            - Extract the city, locality, sector, village, or area if mentioned.
            - Otherwise return null.

            - bedrooms
            - Extract the number of bedrooms.
            - Examples:
                2 bhk -> 2
                3 bedroom -> 3
            - Otherwise return null.

            - bathrooms
            - Extract the number of bathrooms if explicitly mentioned.
            - Otherwise return null.

            - listing_type
            - "sale" if buying.
            - "rent" if renting.
            - Otherwise null.

            - min_price
            - Extract the minimum budget only when explicitly mentioned.
            - Examples:
                above 50 lakh
                minimum 30 lakh
                at least 1 crore
            - Otherwise null.

            - max_price
            - Extract the maximum budget only when explicitly mentioned.
            - Examples:
                under 50 lakh
                below 25 lakh
                maximum 1 crore
                less than 80 lakh
            - Otherwise null.

            Convert Indian currency:

            - 1 thousand = 1,000
            - 1 lakh = 100,000
            - 1 crore = 10,000,000

            Rules:

            - Never invent values.
            - Never add extra fields.
            - Use null when information is missing.
            - search must never be empty.
            - Return valid JSON only.

            Examples:

            User:
            2 bhk apartment for sale in Mohali under 80 lakh

            Output:
            {
            "search": "apartment",
            "location": "Mohali",
            "bedrooms": 2,
            "bathrooms": null,
            "listing_type": "sale",
            "min_price": null,
            "max_price": 8000000
            }

            User:
            Luxury villa with swimming pool in Chandigarh

            Output:
            {
            "search": "luxury villa swimming pool",
            "location": "Chandigarh",
            "bedrooms": null,
            "bathrooms": null,
            "listing_type": null,
            "min_price": null,
            "max_price": null
            }

            User:
            Office for rent above 20000 below 50000

            Output:
            {
            "search": "office",
            "location": null,
            "bedrooms": null,
            "bathrooms": null,
            "listing_type": "rent",
            "min_price": 20000,
            "max_price": 50000
            }
            PROMPT;
        $schema = [
                    "type" => "object",
                    "properties" => [
                        "search" => [
                            "type" => "string"
                        ],
                        "location" => [
                            "type" => ["string", "null"]
                        ],
                        "bedrooms" => [
                            "type" => ["integer", "null"]
                        ],
                        "bathrooms" => [
                            "type" => ["integer", "null"]
                        ],
                        "listing_type" => [
                            "type" => ["string", "null"],
                            "enum" => ["sale", "rent", null]
                        ],
                        "min_price" => [
                            "type" => ["integer", "null"]
                        ],
                        "max_price" => [
                            "type" => ["integer", "null"]
                        ]
                    ],
                    "required" => [
                        "search",
                        "location",
                        "bedrooms",
                        "bathrooms",
                        "listing_type",
                        "min_price",
                        "max_price"
                    ]
                ];
        $response = Http::get('http://127.0.0.1:8001/ownacres/search', [
            'system_prompt' => $system_prompt,
            'query' => $query,
            'schema' => $schema,
            'model' => "qwen3:8b",
        ]);
    
        $data = $response->json();

        $builder = Property::search($data['query']);
            
        $getproperties = $builder->get();

        $ids = $getproperties->pluck('id')->toArray();

        // using mysql
        $query = Property::with([
            'coverImage',
            'basics',
            'pricing',
        ])->whereIn('id', $ids);

        if ($request->listing_type) {
            $query->whereHas('pricing', function ($q) use ($request) {
                $q->where('listing_type', $request->listing_type);
            });
        }

        if ($request->min_budget) {
            $query->whereHas('pricing', function ($q) use ($request) {
                $q->where('price', '>=', $request->min_budget);
            });
        }

        if ($request->max_budget) {
            $query->whereHas('pricing', function ($q) use ($request) {
                $q->where('price', '<=', $request->max_budget);
            });
        }

        $properties = $query
            ->orderByRaw('FIELD(id,' . implode(',', $ids) . ')')
            ->paginate(12);

        return response()->json([
            'html' => view('sections.marketplace.show_properties', compact('properties'))->render(),
            'query' => $query
        ]);
    }
}
