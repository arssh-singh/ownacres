<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_pricing', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('listing_type', ['sale', 'rent']);

            $table->unsignedBigInteger('price');

            $table->boolean('negotiable')->default(false);

            $table->unsignedInteger('maintenance_charge')->nullable();

            $table->unsignedInteger('security_deposit')->nullable();

            $table->string('price_unit')->default('total');
            // total, month, sqft

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_pricing');
    }
};
