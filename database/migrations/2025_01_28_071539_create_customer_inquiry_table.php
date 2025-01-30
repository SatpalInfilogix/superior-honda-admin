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
        Schema::create('customer_inquiry', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->bigInteger('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->enum('inquiry_category', ['products', 'services', 'accessories'])->default('products');
            $table->unsignedBigInteger('inquiry_product_id')->nullable();
            $table->unsignedBigInteger('inquiry_location_id')->nullable();
            $table->enum('inquiry_status', ['pending', 'in_process', 'closed', 'failed'])->default('pending');
            $table->longText('inquiry_description')->nullable();
            $table->dateTime('inquiry_created_at')->nullable();
            $table->unsignedBigInteger('inquiry_attended_by_csr_id')->nullable();
            $table->longText('inquiry_attended_by_csr_comment')->nullable();
            $table->enum('status', ['active', 'inactive', 'delete'])->default('active');
            $table->softDeletes('deleted_at');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('inquiry_product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('inquiry_location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('inquiry_attended_by_csr_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_inquiry');
    }
};
