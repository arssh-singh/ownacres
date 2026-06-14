<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    // ✅ Allow mass assignment
    protected $fillable = [
        'title',
        'description',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'location',
        'is_furnished',
        'image',
        'user_id'
    ];

    // ✅ Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_properties')
                    ->withTimestamps();
    }
    public function isSavedBy(User $user)
    {
        return $this->savedByUsers()->where('user_id', $user->id)->exists();
    }
}
