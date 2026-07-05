<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Facades\File;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Testing User',
            'email' => 'testing@example.com',
        ]);
        $properties = json_decode(
                File::get(storage_path('app/public/seed/properties.json')),
                true
            );
        Property::factory()
                ->count(500)
                ->for($user)
                ->create()
                ->each(function ($property) use ($properties) {
                        $data = fake()->randomElement($properties);
                        $property->basics()->create([
                            'title' => $data['title'],
                            'description' => $data['description'],
                            ]);

                        $property->pricing()->create([
                            'listing_type' => $data['listing_type'],
                            'price' => $data['price'],
                        ]);
                        
                        $mediaCount = fake()->numberBetween(1, 10);

                        for ($i = 1; $i <= $mediaCount; $i++) {

                            $image = fake()->numberBetween(1, 5);

                            $property->media()->create([
                                'file_path'      => "tmp/properties/{$image}.jpg",
                                'thumbnail_path' => "tmp/properties/{$image}.jpg",
                                'mime_type'      => 'image/jpeg',
                                'file_size'      => fake()->numberBetween(150000, 5000000),
                                'width'          => fake()->randomElement([1280, 1600, 1920, 2560]),
                                'height'         => fake()->randomElement([720, 900, 1080, 1440]),
                                'duration'       => null,
                                'sort_order'     => $i,
                                'is_cover'       => $i === 1,
                            ]);
                        }
                    });

    }
}
