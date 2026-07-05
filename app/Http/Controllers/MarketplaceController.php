<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
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
        $query = Property::query()->with('pricing')->where('status', 'published');

        $query->whereHas('pricing', function ($q) use ($request) {

            if ($request->filled('budget_min')) {
                $q->where('price', '>=', $request->budget_min);
            }

            if ($request->filled('budget_max')) {
                $q->where('price', '<=', $request->budget_max);
            }

        });

        $properties = $query->paginate(12);

        return response()->json([
            'budget' => $request->all(),
            'html' => view(
                'sections.marketplace.show_properties',
                compact('properties')
            )->render(),
        ]);
    }
}
