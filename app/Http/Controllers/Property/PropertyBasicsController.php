<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Property\PropertyBasics;

class PropertyBasicsController extends Controller
{
    public function store(Request $request, Property $property){
        $this->authorize('update', $property);
        $validated = $request->validate([
            'title' => [
                        'required',
                        'string',
                        'min:10',
                        'max:255',
                    ],

            'description' => [
                        'required',
                        'string',
                        'min:30',
                        'max:5000',
                    ],
        ]);

        $validated['property_id'] = $property->id;

        PropertyBasics::updateOrCreate(
                            ['property_id' => $property->id],
                            $validated
                        );

        return redirect()->route('properties.pricing.get', $property);
    }
    public function update(){
        
    }
}
