<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Property;
use Carbon\Carbon;

#[Signature('app:migrate-property-id-data')]
#[Description('Command description')]
class MigratePropertyIdData extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $old_properties = DB::table('properties_old')->get();
        foreach($old_properties as $old){
            $property = Property::create([
                'id' => $old->id,
                'user_id' => $old->user_id,
                'status' => 'published',
                'created_at' => $old->created_at,
                'updated_at' => $old->updated_at,
                'uploaded_at' => Carbon::now()
            ]);
        }
    }
}
