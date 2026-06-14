<?php

namespace App\Http\Controllers;
use App\Models\Property;
use Illuminate\Http\Request;

class SavedPropertyController extends Controller
{
    public function toggle(Property $property)
    {
        auth()->user()->savedProperties()->toggle($property->id);

        return back();
    }
}
