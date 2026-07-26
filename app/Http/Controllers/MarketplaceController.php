<?php

namespace App\Http\Controllers;
use App\Models\Property;

class MarketplaceController extends Controller
{
    public function marketplace()
    {
        $properties = Property::with(['media', 'coverImage', 'basics'])
        ->where('status', 'published')
        ->latest()
        ->paginate(12);
        $ids = $properties->getCollection()->pluck('id')->toArray();
        return view('marketplace', compact('properties', 'ids'));
    }
}
