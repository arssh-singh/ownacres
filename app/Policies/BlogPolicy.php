<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function update(User $user, Blog $blog): bool
    {
        return $user->id === $blog->author_id;
    }
}
