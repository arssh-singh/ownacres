<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Property\PropertyPricing;

class PropertyPricingController extends Controller
{
    public function store(Request $request, Property $property){
        $this->authorize('update', $property);
        $validated = $request->validate([
            'listing_type' => 'required|in:sale,rent',
            'price' => 'required|numeric|min:0',
        ]);
        PropertyPricing::updateOrCreate(
            [
                'property_id' => $property->id,
            ],
            $validated
        );

        return redirect()->route('properties.location.get', $property);
    }
}
