<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['name', 'email', 'password', 'profile_image'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        /**
     * Get the URL to the user's profile image, or a default avatar.
     */
    public function getProfileImageUrlAttribute(): string
    {
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : asset('storage/images/default_profile.jpg'); // Default avatar image
    }
    public function savedProperties()
    {
        return $this->belongsToMany(Property::class, 'saved_properties')
                    ->withTimestamps();
    }
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    protected static function booted(): void
    {
        static::created(function (User $user) {
            $user->profile()->create();
        });
    }
}
