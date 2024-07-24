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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('product_name')->nullable();
            $table->string('menu')->nullable();
            $table->string('submenu')->nullable();
            $table->enum('status',['active', 'deactive'])->default('active');
            $table->enum('type',['main_banner', 'side_banner', 'center_banner', 'banner'])->default('main_banner');
            $table->string('size')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
