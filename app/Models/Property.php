<?php

namespace App\Models;

use App\Models\Property\PropertyPricing;
use App\Models\Property\PropertyMedia;
use Illuminate\Database\Eloquent\Model;
use App\Models\Property\PropertyBasics;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
class Property extends Model
{
    use HasFactory;
    use Searchable;
    
    // ✅ Allow mass assignment
    protected $fillable = [
        'id',
        'user_id',
        'status',
        'created_at',
        'uploaded_at',
        'updated_at',
    ];
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,

            'title' => $this->basics?->title,
            'description' => $this->basics?->description,

            'price' => $this->pricing?->price,
            'listing_type' => $this->pricing?->listing_type,
        ];
    }
    public function makeAllSearchableUsing($query)
    {
        return $query->with([
            'basics',
            'pricing',
        ]);
    }

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
    public function media()
    {
        return $this->hasMany(PropertyMedia::class)
            ->where('is_cover', 0)
            ->orderBy('sort_order');
    }

    public function coverImage()
    {
        return $this->hasOne(PropertyMedia::class)
            ->where('is_cover', true);
    }
    public function basics()
    {
        return $this->hasOne(PropertyBasics::class);
    }
    public function pricing()
    {
        return $this->hasOne(PropertyPricing::class);
    }
    public function listing_type()
    {
        return $this->hasOne(PropertyPricing::class)->where('listing_type', true);;
    }



    // ───── Accessors ─────

    public function getDisplayTitleAttribute(): string
    {
        return $this->basics?->title ?? 'Untitled';
    }

    public function getDisplayDescriptionAttribute(): string
    {
        return $this->basics?->description ?? '';
    }

    // public function getFormattedPriceAttribute(): string
    // {
    //     return '₹' . number_format($this->price, 2);
    // }

    public function getCoverImageUrlAttribute(): string
    {
        return $this->coverImage
            ? asset('storage/' . $this->coverImage->file_path)
            : asset('images/placeholder.jpg');
    }
    public function getPriceAttribute(): ?int
    {
        return $this->pricing?->price;
    }
    
}
