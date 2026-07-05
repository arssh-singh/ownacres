<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class PropertyPricing extends Model
{
    protected $table = 'property_pricing';
    protected $fillable=[
        'property_id',
        'price',
        'listing_type',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
