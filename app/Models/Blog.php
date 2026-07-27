<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
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
}
