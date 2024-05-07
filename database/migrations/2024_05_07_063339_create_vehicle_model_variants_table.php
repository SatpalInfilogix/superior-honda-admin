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
        Schema::create('vehicle_model_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('variant_name');
            $table->string('fuel_type');
            $table->string('model_variant_image')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('vehicle_categories');
            $table->foreign('brand_id')->references('id')->on('vehicle_brands');
            $table->foreign('model_id')->references('id')->on('vehicle_models');
            $table->foreign('type_id')->references('id')->on('vehicle_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_model_variants');
    }
};
