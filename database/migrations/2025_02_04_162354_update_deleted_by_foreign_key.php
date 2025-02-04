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
        Schema::table('branch_locations', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']); 

            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_locations', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);

            $table->foreign('deleted_by')->references('id')->on('branches')->onDelete('set null');
        });
    }
};
