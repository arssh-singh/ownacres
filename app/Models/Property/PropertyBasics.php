<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class PropertyBasics extends Model
{
    protected $fillable=[
        'property_id',
        'title',
        'description',
        'created_at',
        'updated_at'
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
