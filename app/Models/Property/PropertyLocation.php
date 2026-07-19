<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
class PropertyLocation extends Model
{
    protected $fillable = [
        'property_id',
        'city',
        'locality',
        'postal_code',
        'address',
        'latitude',
        'longitude',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
