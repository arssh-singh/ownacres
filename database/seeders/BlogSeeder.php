<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Facades\File;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/blogs.json'));

        $export = json_decode($json, true);

        foreach ($export as $item) {

            if (($item['type'] ?? '') !== 'table') {
                continue;
            }

            foreach ($item['data'] as $blog) {

                Blog::create([

                    'title' => $blog['title'],

                    'subtitle' => $blog['subtitle'] ?? null,

                    'content' => $blog['content'],

                    // Change this if you want to preserve authors
                    'author_id' => 1,

                    'meta_description' => $blog['meta_des'] ?? null,

                    'tags' => $blog['tags'] ?? null,

                    'date_published' => $blog['date_published'] ?? null,

                    'date_modified' => $blog['date_modified'] ?? null,

                    'image_url' => $blog['image_url'] ?? null,

                ]);

            }

        }
    }
}