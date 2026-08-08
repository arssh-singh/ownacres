<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Policies\BlogPolicy;

class Blog extends Model
{
    protected $fillable = [
                            'status',
                            'title',
                            'subtitle',
                            'content',
                            'author_id',
                            'meta_description',
                            'tags',
                            'image_url',
                            'date_published',
                            'date_modified',
                       ];
    protected $policies = [
        Blog::class => BlogPolicy::class,
    ];
}
