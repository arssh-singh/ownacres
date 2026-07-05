<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
class PropertyMedia extends Model
{
    protected $fillable = [

        'property_id',

        'type',

        'file_path',

        'thumbnail_path',

        'is_cover',

        'sort_order'

    ];
    public function property(){
        return $this->belongsTo(Property::class);
    }
}
