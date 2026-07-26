<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Property\PropertyLocation;
use App\Services\Search\PropertyIndexService;
use Illuminate\Http\Request;

class PropertyLocationController extends Controller
{
    public function __construct(
        private PropertyIndexService $propertyIndexService
    ) {}

    public function store(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'city'         => 'required|string|max:255',
            'locality'     => 'nullable|string|max:255',
            'postal_code'  => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:500',
            'latitude'     => 'required|numeric|between:-90,90',
            'longitude'    => 'required|numeric|between:-180,180',
        ]);

        PropertyLocation::updateOrCreate(
            [
                'property_id' => $property->id,
            ],
            $validated
        );

        $this->propertyIndexService->index($property);

        $property->update([
            'status' => 'published',
        ]);

        return redirect()->route('dashboard.properties')
            ->with('success', 'Property published successfully.');
    }
    public function update(){
        
    }
}