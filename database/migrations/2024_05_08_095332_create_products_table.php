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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('hsn_no')->nullable();
            $table->string('manufacture_name')->nullable();
            $table->string('supplier')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('out_of_stock')->default(0);
            $table->boolean('is_service')->default(0);
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
        Schema::dropIfExists('products');
    }
};
