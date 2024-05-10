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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cus_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('varient_model_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('color')->nullable();
            $table->string('last_mileage')->nullable();
            $table->string('chasis_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('additional_details')->nullable();
            $table->string('year')->nullable();
            $table->string('vehicle_no')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
