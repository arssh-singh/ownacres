<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Property;
use App\Models\Property\PropertyMedia;

#[Signature('property:migrate-media')]
#[Description('Move existing property images into property_media table')]
class MigratePropertyImages extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
         $count = 0;

        $properties = Property::whereNotNull('image')->get();

        foreach ($properties as $property) {

            // Skip if already migrated
            if (
                PropertyMedia::where('property_id', $property->id)
                    ->where('is_cover', true)
                    ->exists()
            ) {
                continue;
            }

            PropertyMedia::create([

                'property_id' => $property->id,

                'type' => 'image',

                'file_path' => $property->image,

                'thumbnail_path' => null,

                'is_cover' => true,

                'sort_order' => 0

            ]);

            $count++;

            $this->info("Migrated Property #{$property->id}");

        }

        $this->newLine();

        $this->info("Finished!");

        $this->info("Migrated {$count} properties.");
    }
}
