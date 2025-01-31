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
        Schema::table('customer_inquiry', function (Blueprint $table) {
            $table->dropColumn('inquiry_category'); // Replace 'column_name' with the actual column name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_inquiry', function (Blueprint $table) {
            $table->string('inquiry_category'); // Define the column again for rollback (modify type accordingly)
        });
    }
};
