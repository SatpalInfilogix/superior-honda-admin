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
        Schema::create('branch_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'delete'])->default('active');
            $table->softDeletes('deleted_at');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_locations');
    }
};
