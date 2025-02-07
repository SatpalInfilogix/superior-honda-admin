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
        Schema::create('promotions_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive', 'delete'])->default('active');
            $table->softDeletes('deleted_at');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions_images');
    }
};
